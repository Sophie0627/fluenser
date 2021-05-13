import {useEffect, useState} from "react";
import constant from '../../const';

const MessageComponent = (props) => {
    const {chat, userID} = props;
    const [datetime, setDatetime] = useState('');
    useEffect(() => {
        calculateTime();
    }, []);

    const showImage = (src) => {
        $("div#imageModal img").attr("src", src);
        $("div#imageModal").fadeIn(200);
    }

    const calculateTime = () => {
        let time;
        const moment = require('moment-timezone');
        let created_at = chat.created_at;
        const timezone = moment.tz.guess();
        created_at = moment.utc(created_at).tz(timezone).format();
        created_at = created_at.replace(/:|T|-/g, ',');
        let datetime = created_at.split(',');
        if (datetime[3] >= 12) {
            time = datetime[3] - 12 + ":" + datetime[4] + " PM";
        } else {
            time = datetime[3] + ":" + datetime[4] + " AM";
        }
        var month = constant.month[parseInt(datetime[1])];
        var day = datetime[2];
        datetime = time + ', ' + month + ' ' + day;
        setDatetime(datetime);
    }

    const divStyle = {
        float: (chat.send_id == userID) ? 'right' : 'left',
        background: (chat.send_id == userID) ? 'transparent' : 'white',
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
                            <a onClick={() => {showImage(`${constant.baseURL}storage/upload-image/${chat.upload}.jpg`)}}>
                            <img className="rounded-xl w-1/2"
                                 src={constant.baseURL + 'storage/upload-image/' + chat.upload + '.jpg'}
                                 alt={chat.upload} style={divStyle}/>
                            </a>
                            <div className="clearfix"></div>
                        </div>
                }
                {
                    (chat.content == '') ? null :
                        <div>
                            <div className="relative" style={divStyle}>
                                <div style={{border: (chat.send_id == userID) ? '1px solid #999' : 'none'}}>
                                    <p className="text-sm px-4 py-2 text-gray-700">
                                        {chat.content}
                                    </p>
                                </div>
                                <p className={"text-xs text-gray-500 mt-2 absolute"}
                                   style={(chat.send_id == userID) ? userDatetimeStyle : clientDatetimeStyle}>
                                    {datetime}
                                </p>
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
                                        <div
                                            className="absolute w-5 h-5 top-2 right-2 rounded-full bg-red-400 text-white text-xs text-center">
                                            <a onClick={() => {
                                                $("div#imageModal").fadeOut(200)
                                            }} className="leading-5"><i className="fas fa-times"/></a>
                                        </div>
                                        <img src="" className="w-full"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                }
            </div>
            <div className="clearfix"></div>
        </div>
    );
}

export default MessageComponent;
