import React from 'react';
import API from '../api';
import constant from '../const';
import $ from 'jquery';
import RequestDetailTopComponent from './requestDetailComponents/RequestDetailTopComponent';
import RequestDetailShowComponent from './requestDetailComponents/RequestDetailShowComponent';
import RequestButton from './requestDetailComponents/RequestButton';
import RequestChat from './requestDetailComponents/RequestChat';
import InputComponent from './requestDetailComponents/InputComponent';

class RequestDetailComponent extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            requestInfo: {},
            accountInfo: {},
            contactInfo: {},
            requestChats: [],
            isWaiting: true,
            isUpload: false,
            uploading: false,
        }
        this.sendMessage = this.sendMessage.bind(this);
        this.updateOffer = this.updateOffer.bind(this);
    }

    componentDidMount() {
        $("nav").hide();
        const headers = {'Accept': 'application/json'};
        const api_token = $("meta[name=api-token]").attr('content');
        API.get(`requestDetail/${this.props.requestID}?api_token=${api_token}`, {
            headers: headers
        })
            .then((response) => {
                if (response.status === 200) {
                    console.log(response.data);
                    this.setState({
                        requestInfo: response.data.requestInfo,
                        accountInfo: response.data.accountInfo,
                        contactInfo: response.data.contactInfo,
                        requestChats: response.data.requestChats,
                        isWaiting: false
                    });
                }
            })
            .catch(error => {
                console.log(error);
            })

        Pusher.logToConsole = true;

        const pusher = new Pusher('da7cd3b12e18c9e2e461', {
            cluster: 'eu',
        });
        const channel = pusher.subscribe('fluenser-channel');
        channel.bind('fluenser-event', (data) => {
            console.log(data);

            if (data.trigger == 'newRequestChat') {
                console.log(data.requestChat, this.state.requestInfo);
                if (parseInt(data.requestChat.request_id) == this.state.requestInfo.request_id) {
                    const tmpRequestChat = this.state.requestChats;
                    tmpRequestChat.push(data.requestChat);
                    this.setState({
                        requestChats: tmpRequestChat,
                    });
                }
            }

            if (data.trigger == 'acceptRequest') {
                if (data.data == 'accepted' && parseInt(data.request_id) == this.state.requestInfo.request_id) {
                    const requestInfos = this.state.requestInfo;
                    requestInfos.accepted = 1;
                    this.setState({
                        requestInfos: requestInfos,
                    })
                }
            }

            // if(data.trigger == 'request_status') {
            //   var requestInfos = requestInfo;
            //   requestInfos.status = data.status;
            //   setRequestInfo(requestInfos);
            //   setUpdate(!update);
            // }
        });

    }

    componentDidUpdate() {
        const element = document.getElementById('requestChatContainer');
        console.log(element);
        if (element != null) {
            console.log("+++++++");
            element.scrollIntoView(false);
        }
    }

    sendMessage(message, file) {
        const api_token = $("meta[name=api-token]").attr('content');
        const bodyFormData = new FormData();
        bodyFormData.append('request_id', this.state.requestInfo.request_id);
        bodyFormData.append('send_id', this.state.accountInfo.id);
        bodyFormData.append('receive_id', this.state.contactInfo.id);
        if (message != '')
            bodyFormData.append('message', message);
        console.log(file);
        if (file.name != undefined) {
            let f;
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onloadend = function () {
                f = reader.result;
                bodyFormData.append('upload', f);
                console.log(bodyFormData);
                API.post('saveRequestChat?api_token=' + api_token,
                    bodyFormData, {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            "Accept": 'application/json',
                        }
                    })
                    .then((res) => {
                        if (res.status == 200)
                            this.setState({
                                message: '',
                                file: {},
                                isUpload: false,
                            });
                    })
                    .catch(error => {
                        console.log(error.response.data);
                    });
            }
        } else {
            API.post('saveRequestChat?api_token=' + api_token,
                bodyFormData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        "Accept": 'application/json',
                    }
                })
                .then((res) => {
                    if (res.status == 200)
                        this.setState({
                            message: '',
                            file: {}
                        })
                })
                .catch(error => {
                    console.log(error.response.data);
                });
        }

        console.log(this.state.message);
    }

    updateOffer(price, currency) {
        console.log(currency);
        const newRequestInfo = this.state.requestInfo;
        newRequestInfo.amount = price;
        newRequestInfo.unit = currency;
        newRequestInfo.gift = 0;
        this.setState({
            requestInfo: newRequestInfo
        })
    }

    render() {
        if (this.state.isWaiting) {
            return (
                <div className="max-w-sm mx-auto py-10 text-center">
                    <img src={constant.baseURL + 'img/waiting.gif'} alt="waiting" className="mx-auto"/>
                </div>
            )
        } else {
            const containerHeight = innerHeight - 170;
            const messengerWidth = $('main').css('width').slice(0, -2) - 110;
            let created_at = this.state.requestInfo.created_at;
            if (created_at[created_at.length - 1] == 'Z') {
                created_at = created_at.slice(0, -8).replace(/:|T|-/g, ',');
            } else {
                created_at = created_at.replace(/:| |-/g, ',');
            }
            let datetime = created_at.split(',');
            let time;
            if (datetime[3] >= 12) {
                time = datetime[3] - 12 + ":" + datetime[4] + " PM";
            } else {
                time = datetime[3] + ":" + datetime[4] + " AM";
            }
            const month = constant.month[parseInt(datetime[1])];
            const day = datetime[2];
            datetime = time + ', ' + month + ' ' + day;
            if (parseInt(this.state.requestInfo.amount) == 0 && parseInt(this.state.requestInfo.gift) == 0 && this.state.accountInfo.accountType == "brand")
                return (
                    <div>
                        <RequestDetailTopComponent
                            contactInfo={this.state.contactInfo}
                            back={this.props.back}
                        />
                        <RequestButton
                            requestInfo={this.state.requestInfo}
                            accountInfo={this.state.accountInfo}
                            contactInfo={this.state.contactInfo}
                            handleUpdateOffer={this.updateOffer}
                            back={this.props.back}
                        />
                    </div>
                );
            else
                return (
                    <div>
                        <RequestDetailTopComponent
                            contactInfo={this.state.contactInfo}
                            back={this.props.back}
                        />

                        <div className="bg-gray-100 pt-2">
                            <div className="relative">
                                <div id="chatContainer" style={{height: containerHeight + 'px', overflow: 'auto'}}>
                                    <RequestDetailShowComponent
                                      requestInfo={this.state.requestInfo}
                                      datetime={datetime}
                                    />
                                    <div id="requestChatContainer" className="relative">
                                        {
                                            this.state.requestChats.map((chat, i) => {
                                                return (
                                                    <div key={i} className="w-full mx-auto rounded px-2 mt-5">
                                                        <RequestChat
                                                            chat={chat}
                                                            accountInfo={this.state.accountInfo}
                                                            key={i}
                                                        />
                                                    </div>
                                                );
                                            })
                                        }
                                        <RequestButton
                                            requestInfo={this.state.requestInfo}
                                            accountInfo={this.state.accountInfo}
                                            contactInfo={this.state.contactInfo}
                                            handleUpdateOffer={this.updateOffer}
                                            back={this.props.back}
                                        />
                                        <div className="h-40"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <InputComponent
                            sendMessage={(message, file) => this.sendMessage(message, file)}
                        />
                    </div>
                );
        }
    }
}

export default RequestDetailComponent;
