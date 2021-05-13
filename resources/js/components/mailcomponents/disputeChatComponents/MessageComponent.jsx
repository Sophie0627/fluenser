import { useEffect, useState } from "react";
import constant from '../../const';

const MessageComponent = (props) => {
  const {chat, userID} = props;
  const [datetime, setDatetime] = useState('');
  useEffect (() => {
    calculateTime();
  }, []);

  const calculateTime = () => {
      let time;
      const moment = require('moment-timezone');
      let created_at = chat.created_at;
      const timezone = moment.tz.guess();
      created_at = moment.utc(created_at).tz(timezone).format();
      created_at = created_at.replace(/:|T|-/g, ',');
      let datetime = created_at.split(',');
      if(datetime[3] >= 12){
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
            <img className="rounded-xl w-1/2" src={constant.baseURL + 'storage/upload-image/' + chat.upload + '.jpg'} alt={ chat.upload } style={divStyle}/>
            <div className="clearfix"></div>
          </div>
        }
        {
          (chat.content == '') ? null :
          <div>
            <div className="relative" style={divStyle}>
              <div style={{border:'1px solid #999'}} >
                <p className="text-sm px-4 py-2 text-gray-700">
                  {chat.content}
                </p>
              </div>
              <p className={"text-xs text-gray-500 mt-2 absolute"} style={(chat.send_id == userID) ? userDatetimeStyle : clientDatetimeStyle}>
                {datetime}
              </p>
            </div>
            <div className="clearfix"></div>
          </div>
        }
      </div>
      <div className="clearfix"></div>
    </div>
  );
}

export default MessageComponent;
