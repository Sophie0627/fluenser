import React from 'react';
import API from '../api';
import constant from '../const';
import $ from 'jquery';
import DetailComponent from './chatComponents/DetailComponent';
import ChatTopComponent from './chatComponents/ChatTopComponent';
import MessageComponent from './chatComponents/MessageComponent';
import InputComponent from './chatComponents/InputComponent';

class ChatComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            chats: [],
            contactName: '',
            userID: 0,
            isWaiting: true,
            contactInfo: {},
            contactID: 0,
            requestInfo: {},
            inboxInfo: {},
            update: false,
            isShowDetail: false,
            isBlocked: false,
            isBlock: false,
            accountInfo: {}
        };
        this.sendMessage = this.sendMessage.bind(this);
        this.showDetail = this.showDetail.bind(this);
        this.handleDispute = this.handleDispute.bind(this);
        this.handleBlock = this.handleBlock.bind(this);
    }

    sendMessage(message, file) {
        const api_token = $("meta[name=api-token]").attr('content');
        const bodyFormData = new FormData();
        bodyFormData.append('inbox_id', this.state.chats[0].inbox_id);
        if (message != '')
            bodyFormData.append('msg', message);
        console.log(file);
        if (file.name != undefined) {
            let f;
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                f = reader.result;
                bodyFormData.append('upload', f);
                console.log("image");
                console.log(f);
                API.post('sendMessage?api_token=' + api_token,
                    bodyFormData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            "Accept": 'application/json',
                        }
                    }).then((res) => {
                    if (res.status == 200) {
                        console.log("success");
                        console.log(res.data.data);
                    }
                }).catch((XMLHttpRequest, textStatus, errorThrown) => {
                    console.log(XMLHttpRequest, textStatus, errorThrown);
                });
            }
        } else {
            API.post('sendMessage?api_token=' + api_token,
                bodyFormData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        "Accept": 'application/json',
                    }
                }).then((res) => {
                if (res.status == 200) {
                    console.log(res.data.data);
                }
            }).catch(error => {
                console.log(error);
            });
        }
    }

    showDetail() {
        this.setState({
            isShowDetail: true,
        })
    }

    handleDispute() {
        const api_token = $("meta[name=api-token]").attr('content');
        const headers = {"Accept": 'application/json'};
        API.get('dispute/' + this.state.requestInfo.request_id + "?api_token=" + api_token, {headers})
            .then((res) => {
                if (res.status == 200) {
                    this.props.afterDispute();
                }
            })
            .catch(error => console.log(error));
    }

    handleBlock() {
        const api_token = $("meta[name=api-token]").attr('content');
        const headers = {"Accept": 'application/json'};
        API.get(`block/${this.state.chats[0].inbox_id}/${this.state.accountInfo.id}?api_token=${api_token}`, {headers})
            .then((res) => {
                if (res.status == 200) {
                    const newInbox = res.data.inbox;
                    if (newInbox.user1_block == 0 && newInbox.user2_block == 0)
                        this.setState({isBlocked: false});
                    else
                        this.setState({isBlocked: true});
                    console.log(newInbox, this.state.userID);
                    if(newInbox.user1_id == this.state.userID && newInbox.user1_block == 1 ||
                        newInbox.user2_id == this.state.userID && newInbox.user2_block == 1)
                        this.setState({isBlock: true});
                    else
                        this.setState({isBlock: false});
                    this.setState({inboxInfo: newInbox});
                    this.setState({update: !this.state.update});
                    console.log(this.state.isBlock);
                }
            })
            .catch(error => console.log(error));
    }

    componentDidMount() {
        $("nav").hide();
        const headers = {
            'Accept': 'application/json'
        };
        const api_token = $("meta[name=api-token]").attr('content');
        API.get(`chat/${this.props.inboxID}?api_token=${api_token}`, {
            headers: headers
        })
            .then((response) => {
                this.setState({isWaiting: false});
                if (response.status == 200) {
                    console.log(response.data);
                    this.setState({
                        chats: response.data.data.chatInfo,
                        inboxInfo: response.data.inbox,
                        contactName: response.data.data.name,
                        userID: response.data.data.userID,
                        contactInfo: response.data.contactInfo[0],
                        accountInfo: response.data.accountInfo[0],
                        contactID: response.data.contactID,
                        requestInfo: response.data.data.requestInfo,
                    });
                    if (response.data.inbox.user1_block == 1 || response.data.inbox.user2_block == 1) {
                        this.setState({isBlocked: true});
                    }
                    if (response.data.inbox.user1_block == 1 && response.data.inbox.user1_id == response.data.data.userID ||
                        response.data.inbox.user2_block == 1 && response.data.inbox.user2_id == response.data.data.userID) {
                        this.setState({isBlock: true});
                    }
                }
            })
            .catch(err => {
                console.log(err);
            });

        Pusher.logToConsole = true;
        const pusher = new Pusher('da7cd3b12e18c9e2e461', {
            cluster: 'eu',
        });
        const channel = pusher.subscribe('fluenser-channel');
        channel.bind('fluenser-event', (data) => {
            console.log('pusher');
            console.log(data);
            if (data.trigger == 'chat') {
                console.log(data.inboxInfo.send_id);
                console.log(data.inboxInfo.receive_id);

                if (this.state.userID == data.inboxInfo.send_id &&
                    this.state.contactID == data.inboxInfo.receive_id ||
                    this.state.userID == data.inboxInfo.receive_id &&
                    this.state.contactID == data.inboxInfo.send_id) {
                    const chat = this.state.chats;
                    chat.push(data.inboxInfo);
                    this.setState({
                        chats: chat,
                        update: !this.state.update,
                    })
                }
            }

            if (data.trigger == 'request_status') {
                if (data.request_id == this.state.requestInfo.id) {
                    var requestInfos = this.state.requestInfo;
                    requestInfos.status = data.status;
                    this.setState({
                        requestInfo: requestInfos,
                        update: !this.state.update,
                    })
                }
            }
        });
    }

    componentDidUpdate() {
        const element = document.getElementById('chatcontainer');
        if (element != null) {
            console.log('+++++++++++');
            element.scrollIntoView(false);
        }
    }

    render() {
        if (this.state.isWaiting) {
            return (
                <div className="max-w-sm mx-auto py-10 text-center">
                    <img src={`${constant.baseURL}img/waiting.gif`} alt="waiting" className="mx-auto"/>
                </div>
            );
        } else {
            const containerHeight = innerHeight - 170;
            return (
                (this.state.isShowDetail)
                    ?
                    <DetailComponent
                        hideDetail={() => {
                            this.setState({isShowDetail: false})
                        }}
                        requestInfo={this.state.requestInfo}
                        contactInfo={this.state.contactInfo}
                        accountInfo={this.state.accountInfo}
                        chats={this.state.chats}
                        handleBlock={() => this.handleBlock()}
                        handleDispute={() => this.handleDispute()}
                        isBlock={this.state.isBlock}
                    />
                    :
                    <div className="w-full text-center">
                        <ChatTopComponent
                            requestInfo={this.state.requestInfo}
                            contactInfo={this.state.contactInfo}
                            contactName={this.state.contactName}
                            back={this.props.back}
                            showDetail={() => this.showDetail()}
                            parent='chat'
                        />
                        <div style={{height: containerHeight + 'px', overflow: 'auto'}} className="bg-gray-100">
                            <div id="chatcontainer" className="relative">
                                {
                                    this.state.chats.map((chat, i) => {
                                        return (
                                            <div key={i} className="w-full mx-auto rounded px-2 mt-5">
                                                <MessageComponent
                                                    chat={chat}
                                                    userID={this.state.userID}
                                                />
                                            </div>
                                        )
                                    })
                                }
                                <div className="h-40"/>
                            </div>
                        </div>
                        <InputComponent
                            inboxID={this.props.inboxID}
                            requestInfo={this.state.requestInfo}
                            sendMessage={(message, file) => this.sendMessage(message, file)}
                            inboxClickEvent={() => this.props.inboxClickEvent(this.props.inboxID)}
                            isBlocked={this.state.isBlocked}
                        />
                    </div>
            );
        }
    }
}

export default ChatComponent;
