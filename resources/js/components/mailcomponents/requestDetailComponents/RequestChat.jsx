import {useEffect, useState} from "react";
import constant from '../../const';

const RequestChat = (props) => {
    const {chat, accountInfo} = props;
    const [datetime, setDatetime] = useState('');
    const [isUser, setIsUser] = useState(true);
    useEffect(() => {
        calculateTime();
        setIsUser(chat.send_id == accountInfo.id);
    }, []);

    const showImage = (src) => {
        $("div#imageModal img").attr("src", src);
        $("div#imageModal").fadeIn(200);
    }

    const calculateTime = () => {
        var moment = require('moment-timezone');
        var created_at = chat.created_at;
        console.log(created_at);
        var timezone = moment.tz.guess();
        created_at = moment.utc(created_at).tz(timezone).format();
        created_at = created_at.replace(/:|T|-/g, ',');
        console.log(created_at);
        var datetime = created_at.split(',');
        if (datetime[3] >= 12) {
            var time = datetime[3] - 12 + ":" + datetime[4] + " PM";
        } else {
            var time = datetime[3] + ":" + datetime[4] + " AM";
        }
        var month = constant.month[parseInt(datetime[1])];
        var day = datetime[2];
        datetime = time + ', ' + month + ' ' + day;
        setDatetime(datetime);
    }

    const divStyle = {
        float: (isUser) ? 'right' : 'left',
        background: (isUser) ? 'transparent' : 'linear-gradient(to right, #6553e7, #0ac9c4)',
        paddingBottim: '1px'
    }
    const userDatetimeStyle = {
        left: 0
    }
    const clientDatetimeStyle = {
        right: 0
    }

    return (
        <div>
            <div style={divStyle}>
                {
                    (chat.upload == 'none') ? null :
                        <div>
                            <a onClick={() => {showImage(`${constant.baseURL}storage/upload-image/${chat.upload}.jpg`);}}>
                                <img className="rounded-xl w-1/2"
                                     src={`${constant.baseURL}storage/upload-image/${chat.upload}.jpg`}
                                     alt={chat.upload} style={divStyle}/>
                            </a>
                            <div className="clearfix"></div>
                        </div>
                }
                {
                    (chat.content == '') ? null :
                        <div>
                            <div className="relative" style={divStyle}>
                                <div style={{border: (isUser) ? '1px solid #999' : 'none'}}>
                                    <p className="text-sm px-4 py-2 text-gray-700 bg-white">
                                        {chat.content}
                                    </p>
                                </div>
                                <p className={"text-xs text-gray-500 mt-2 absolute"}
                                   style={(isUser) ? userDatetimeStyle : clientDatetimeStyle}>
                                    {datetime}
                                </p>
                            </div>
                            <div className="clearfix"></div>
                        </div>
                }
            </div>
            <div className="clearfix"></div>
            <div id="imageModal" className="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
                <div className="w-11/12 bg-white absolute rounded-xl" style={{
                    top: '50%',
                    marginTop: '-6rem',
                    left: '50%',
                    marginLeft: '-45.83333%',
                    transform: 'translateY(-25%)'
                }}>
                    <div className="relative">
                        <div className="absolute w-5 h-5 top-2 right-2 rounded-full bg-red-400 text-white text-xs text-center">
                            <a onClick={() => {$("div#imageModal").fadeOut(200)}} className="leading-5"><i className="fas fa-times"/></a>
                        </div>
                        <img src="" className="w-full"/>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default RequestChat;
