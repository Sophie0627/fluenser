import React, {Component} from 'react';
import API from '../api';
import constant from '../const';
import $ from 'jquery';

class InboxComponent extends Component {
    constructor(props) {
        super(props);
        this.state = {
            showInboxes: [],
            isWaiting: true,
            inboxSearch: '',
            inboxes: [],
            accountInfo: {},
            inboxID: 0,
        }
        this.onSearch = this.onSearch.bind(this);
        this.onInboxClick = this.onInboxClick.bind(this);
        this.handleOnChange = this.handleOnChange.bind(this);
    }


    onSearch() {
        const keyword = this.state.inboxSearch;
        let tempInboxes = this.state.inboxes;
        let newInboxes = [];
        tempInboxes.map((inbox) => {
            console.log(inbox.accountInfo[0].name.toUpperCase().search(keyword.toUpperCase()));
            if (inbox.accountInfo[0].name.toUpperCase().search(keyword.toUpperCase()) !== -1) {
                newInboxes.push(inbox);
            }
        })
        this.setState({showInboxes: newInboxes});
    }

    showDeleteConfirmModal(inbox_id) {
        this.setState({inboxID: inbox_id});
        $("div#deleteInboxConfirm").fadeIn(200);
    }

    deleteInbox() {
        const headers = {
            'Accept': 'application/json'
        };
        const api_token = $("meta[name=api-token]").attr('content');
        API.get(`deleteInbox/${this.state.inboxID}?api_token=${api_token}`, {
            headers: headers
        }).then((res) => {
            if (res.status === 200) {
                console.log(res.data);
                window.location.reload();
            }
        }).catch(error => {
            console.log(error);
        });
    }

    onInboxClick(inboxID) {
        this.props.onInboxClick(inboxID);
    }

    handleOnChange(e) {
        this.setState({inboxSearch: e.target.value});
    }

    componentDidMount() {
        $("nav").show();
        // send request
        const headers = {
            'Accept': 'application/json'
        };
        const api_token = $("meta[name=api-token]").attr('content');
        API.get('inbox?api_token=' + api_token, {
            headers: headers
        }).then((response) => {
            this.setState({isWaiting: false});
            if (response.status === 200) {
                console.log(response.data.data);
                this.setState({
                    accountInfo: response.data.accountInfo,
                    inboxes: response.data.data,
                    showInboxes: response.data.data,
                });
            }
        }).catch(error => {
            console.log(error);
        })
        console.log("mounted component message");

        // Pusher
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        const pusher = new Pusher('da7cd3b12e18c9e2e461', {
            cluster: 'eu',
        });
        const this1 = this;
        const channel = pusher.subscribe('fluenser-channel');
        channel.bind('fluenser-event', function (data) {
            if (data.trigger === 'newInbox') {
                if (data.request.receive_id === this.state.accountInfo.id) {
                    const inbox = this1.state.inboxes;
                    inbox.push(data.data);
                    this1.setState({
                        inboxes: inbox,
                        showInboxes: inbox,
                    });
                }
            }
        });

        this.props.selectTab('inbox');
    }

    UNSAFE_componentWillMount() {
        if (sessionStorage.getItem('inbox_id')) {
            const inbox_id = sessionStorage.getItem('inbox_id');
            this.onInboxClick(inbox_id);
            sessionStorage.clear();
        }
    }

    // componentWillMount() {
    // }

    render() {
        if (this.state.isWaiting) {
            return (
                <div className="max-w-sm mx-auto py-10 text-center">
                    <img src={constant.baseURL + 'img/waiting.gif'} alt="waiting" className="mx-auto w-1/2"/>
                </div>
            )
        } else {
            if (this.state.showInboxes.length === 0) {
                return (
                    <div>
                        <div id="inboxSearch">
                            <div className="py-2 w-11/12 mx-auto mt-1 relative">
                                <input type="text" value={this.state.inboxSearch} id="inboxSearch"
                                       style={{height: '45px',}}
                                       className="w-full px-6 py-1 rounded-full bg-gray-100 border-none"
                                       onChange={this.handleOnChange} placeholder="Search here..."/>
                                <button className="absolute right-4 text-gray-500" style={{height: '45px'}}
                                        onClick={() => this.onSearch()}>
                                    <i className="fas fa-search"/>
                                </button>
                            </div>
                        </div>
                        <div className="max-w-sm mx-auto text-center py-10">
                            <p className="text-center">
                                No inbox to show
                            </p>
                        </div>
                    </div>
                )
            } else {
                const containerHeight = innerHeight - 230;
                return (
                    <div>
                        <div id="deleteInboxConfirm"
                             className="depositConfirm h-screen w-screen bg-black bg-opacity-70 fixed top-0 left-0 z-50 hidden">
                            <div className="w-11/12 h-48 bg-white absolute rounded-xl"
                                 style={{top: '50%', marginTop: '-6rem', left: '50%', marginLeft: '-45.83333%'}}>
                                <div className="w-8/12 mx-auto h-20 mt-4">
                                    <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5"> Are you sure
                                        you want to delete this message? </p>
                                </div>
                                <div className="w-full h-16" id="confirmBtn">
                                    <div className="w-full grid grid-cols-2 h-full">
                                        <div className="col-span-1 h-full">
                                            <button
                                                className="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white"
                                                onClick={() => $("div#deleteInboxConfirm").fadeOut(200)}>Cancel
                                            </button>
                                        </div>
                                        <div className="col-span-1">
                                            <button
                                                className="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                                                style={{background: '#0ac2c8'}} onClick={() => this.deleteInbox()}>Yes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="inboxSearch">
                            <div className="py-2 w-11/12 mx-auto mt-4 relative">
                                <input type="text" value={this.state.inboxSearch} id="inboxSearch"
                                       style={{height: '45px',}}
                                       className="w-full px-6 py-1 rounded-full bg-gray-100 border-none"
                                       onChange={this.handleOnChange} placeholder="Search here..."/>
                                <button className="absolute right-4 text-gray-500" style={{height: '45px'}}
                                        onClick={() => this.onSearch()}>
                                    <i className="fas fa-search"/>
                                </button>
                            </div>
                        </div>
                        <div className="pt-6 mt-3 w-11/12 mx-auto rounded" style={{boxShadow: '0 0 3px 3px #eee'}}>
                            <div style={{height: containerHeight, overflow: 'auto'}}>
                                {
                                    this.state.showInboxes.map((inbox, i) => {
                                        console.log(inbox);
                                        const moment = require('moment-timezone');
                                        let now = moment.utc(Date.now());
                                        let created_at = moment.utc(inbox.inboxContent[0].created_at);
                                        const difference = Math.abs(now - created_at);
                                        console.log(difference);
                                        let time = 0;
                                        if(difference < (1000 * 60 * 60)) {
                                            console.log('minutes');
                                            time = Math.floor(difference / 1000 / 60) + ' minutes';
                                        } else if(1000 * 60 * 60 * 24 > difference && difference > 1000 * 60 * 60) {
                                            console.log('hours');
                                            time = Math.floor(difference / 1000 / 60 / 60) + ' hours';
                                        } else if(1000 * 60 * 60 * 24 * 7 > difference && difference > 1000 * 60 * 60 * 24){
                                            console.log('hours');
                                            time = Math.floor(difference / 1000 / 60 / 60 / 24) + ' days';
                                        } else if(1000 * 60 * 60 * 24 *7 < difference) {
                                            console.log('hours');
                                            time = Math.floor(difference / 1000 / 60 /60 /24 /7) + ' weeks';
                                        }
                                        console.log(time + "time");
                                        return (
                                            <div key={i} className="w-11/12 mx-auto rounded px-2 relative">
                                                <div className="w-full">
                                                    <div className="w-full">
                                                        <div className="float-left flex-shrink-0 rounded-full" style={{
                                                            width: '55px',
                                                            height: '55px',
                                                            margin: '5px 0',
                                                            padding: '2px',
                                                            marginLeft: '5px',
                                                            background: 'linear-gradient(to right, #06ebbe, #1277d3)'
                                                        }}>
                                                            <div className="w-full bg-white rounded-full" style={{padding: '2px'}}>
                                                                <img
                                                                    src={constant.baseURL + 'storage/profile-image/' + inbox.accountInfo[0].avatar + '.jpg'}
                                                                    alt={inbox.accountInfo[0].avatar} className="rounded-full"
                                                                    style={{width: '100%'}}/>
                                                            </div>
                                                        </div>
                                                        <a href="#" onClick={() => this.onInboxClick(inbox.id)}>
                                                            <div style={{marginLeft: '75px', paddingTop: '3px'}}>
                                                                <span className="text-md md:text-lg font-medium text-gray-700">
                                                                  {inbox.accountInfo[0].name}
                                                                </span>
                                                                <span className="text-xs text-gray-400"
                                                                    style={{float: 'right'}}>
                                                                    {time}
                                                                </span>
                                                            </div>
                                                        </a>
                                                        <div style={{
                                                            marginLeft: '75px',
                                                            height: '40px',
                                                            paddingTop: '3px',
                                                            paddingBottom: '10px',
                                                            overflow: 'hidden'
                                                        }} id={inbox.id}>
                                                            <p style={{height: '20px', overflow: 'hidden'}}
                                                               className="text-gray-500 text-md relative">{(inbox.inboxContent.length > 0) ? inbox.inboxContent[0].content : ''}
                                                                {
                                                                    (inbox.unread)
                                                                        ?
                                                                        <span
                                                                            className="w-2 h-2 absolute rounded-full bg-red-500 bottom-1 right-1 block"/>
                                                                        :
                                                                        <span
                                                                            className="w-2 h-2 absolute rounded-full bg-red-500 bottom-1 right-1 hidden"/>
                                                                }
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a onClick={() => this.showDeleteConfirmModal(inbox.id)}><i
                                                    className="fas fa-times text-xs text-gray-500 absolute right-0.5" style={{bottom:'20px'}}/></a>
                                                <hr className="pb-3"/>
                                            </div>
                                        );
                                    })
                                }
                            </div>
                        </div>
                    </div>
                );
            }
        }
    }
}

export default InboxComponent;
