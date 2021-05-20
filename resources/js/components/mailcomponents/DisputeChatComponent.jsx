import React, { Component } from 'react';
import API from '../api';
import constant from '../const';
import $ from 'jquery';
import ChatTopComponent from './disputeChatComponents/ChatTopComponent';
import MessageComponent from './disputeChatComponents/MessageComponent';
import InputComponent from './disputeChatComponents/InputComponent';

class DisputeChatComponent extends Component {
  constructor(props) {
    super(props);
    this.state = {
      chats: [],
      isWaiting: true,
      contactInfo: {},
      update: false,
      accountInfo: {},
      requestID: 0,
    }
  }

  sendMessage(message, file) {
    const api_token = $("meta[name=api-token]").attr('content');
    let bodyFormData = new FormData();
    bodyFormData.append('request_id', this.state.requestID);
    if(message !== '')
      bodyFormData.append('msg', message);
    console.log(file);
    if(file.name !== undefined)
    {
      let f;
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onloadend = function() {
          f = reader.result;
          bodyFormData.append('upload', f);
          console.log(bodyFormData);
          API.post('sendDisputeMessage?api_token=' + api_token,
            bodyFormData, {headers : {
              'Content-Type': 'multipart/form-data',
              "Accept": 'application/json',
            }
          }).then((res) => {
            if(res.status === 200) {
              console.log(res.data.data);
            }
          }).catch(error => {
            console.log(error.response);
          });
      }
    } else {
      API.post('sendDisputeMessage?api_token=' + api_token,
        bodyFormData, {headers : {
          'Content-Type': 'multipart/form-data',
          "Accept": 'application/json',
        }
      }).then((res) => {
        if(res.status === 200) {
          console.log(res.data.data);
        }
      }).catch(error => {
        console.log(error);
      });
    }
  }

  back() {
    window.location = `${constant.baseURL}collaboration/disputed`;
  }

  componentDidMount() {
    $("nav").hide();
    // request
    const headers = {
      'Accept': 'application/json'
    };
    const request_id = $("div#request_id").text();
    const api_token = $("meta[name=api-token]").attr('content');
    API.get('disputeChats/' + request_id + '?api_token=' + api_token, {
      headers: headers
    }).then((response) => {
      if (response.status === 200) {
        this.setState({isWaiting: false});
        console.log(response);
        this.setState({
          chats: response.data.disputeChats,
          contactInfo: response.data.contactInfo,
          accountInfo: response.data.accountInfo,
          requestID: response.data.request_id,
        })
      }
    }).catch(error => {
      console.log(error);
    });

    // Pusher
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    const pusher = new Pusher('da7cd3b12e18c9e2e461', {
      cluster: 'eu',
    });

    const channel = pusher.subscribe('fluenser-channel');
    channel.bind('fluenser-event', (data) => {
      console.log(data);
      let this1 = this;
      if (data.trigger === 'disputeChat') {
        if (this1.state.accountInfo.id === data.disputeChat.send_id &&
          this1.state.contactInfo.id === data.disputeChat.receive_id ||
          this1.state.accountInfo.id === data.disputeChat.receive_id &&
          this1.state.contactInfo.id === data.disputeChat.send_id) {
          const chat = this1.state.chats;
          chat.push(data.disputeChat);
          this1.setState({
            chats: chat,
          });
        }
      }

      if (data.trigger === 'request_status') {
        if (data.request_id === this1.state.requestInfo.request_id) {
          let requestInfos = this1.state.requestInfo;
          requestInfos.status = data.status;
          this1.setState({requestInfo: requestInfos});
        }
      }
    });
  }

  componentDidUpdate() {
    const element = document.getElementById('chatcontainer');
    if (element != null) {
      element.scrollIntoView(false);
    }
  }

  render() {
    if(this.state.isWaiting) {
      return (
        <div className="max-w-sm mx-auto py-10 text-center">
          <img src={constant.baseURL + 'img/waiting.gif'} alt="waiting" className="mx-auto w-1/2"/>
        </div>
      )
    } else {
      const containerHeight = innerHeight - 170;
      return (
        <div className="w-full text-center">
          <ChatTopComponent
            contactInfo = {this.state.contactInfo}
            parent = 'dispute'
            back = {this.back}
          />
          <div style={{height:containerHeight+'px', overflow:'auto'}} className="bg-gray-100">
            <div id="chatcontainer" className="relative">
              <div id="topdetail" className="w-11/12 mx-auto pt-3 pb-2 px-2 bg-white shadow mt-2 relative">
                <a onClick={() => {$('div#topdetail').hide()}} className="block absolute top-1 right-1 text-red-500 text-xs">
                  <i className="fas fa-times"/>
                </a>
                <p className="text-xs">Describe your reason for the dispute in detail and attach any supporting evidence you may have. A customer support representative will assess the conversation and If the party does not respond within a given time frame or provide sufficient evidence, the dispute will close in your favor.</p>
              </div>
              {
                this.state.chats.map((chat, i)=>{
                  return (
                    <div key={i} className="w-full mx-auto rounded px-2 mt-5">
                      <MessageComponent
                        chat = {chat}
                        userID = {this.state.accountInfo.id}
                      />
                    </div>
                  );
                })
              }
              <div className="h-40"/>
            </div>
          </div>
          <InputComponent
            inboxID = {this.props.inboxID}
            sendMessage = {(message, file) => this.sendMessage(message, file)}
          />
        </div>
      );
    }
  }
}

export default DisputeChatComponent;
