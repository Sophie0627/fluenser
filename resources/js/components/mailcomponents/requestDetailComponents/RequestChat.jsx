import { useEffect, useState } from "react";
import constant from '../../const';

const RequestChat = (props) => {
  const {chat, accountInfo} = props;
  const [datetime, setDatetime] = useState('');
  const [isUser, setIsUser] = useState(true);
  useEffect(() => {
    calculateTime();
    setIsUser(chat.send_id == accountInfo.id);
  }, []);

  const calculateTime = () => {
    var created_at = chat.created_at;
    console.log(created_at);
    if(created_at[created_at.length - 1] == 'Z') {
        created_at = created_at.slice(0, -8).replace(/:|T|-/g, ',');
    } else {
        created_at = created_at.replace(/:| |-/g, ',');
    }
    var datetime = created_at.split(',');
    console.log(datetime);
    if(datetime[3] >= 12){
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
              <p className={"text-xs text-gray-500 mt-2 absolute"} style={(isUser) ? userDatetimeStyle : clientDatetimeStyle}>
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

export default RequestChat;
