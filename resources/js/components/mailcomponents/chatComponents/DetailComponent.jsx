import {useState} from "react";
import constant from "../../const";
import {useHistory} from "react-router-dom";

const DetailComponent = (props) => {
  const {requestInfo, chats, accountInfo, isBlock} = props;
  const [item, setItem] = useState('');
  const history = useHistory();

  const handleBlock = (e) => {
    console.log(isBlock);
    props.handleBlock();
    $("div#blockConfirmModal").fadeOut(200);
  }

  const showImage = (src) => {
    $("div#imageModal img").attr("src", src);
    $("div#imageModal").fadeIn(200);
  }

  const showConfirm = (item) => {
    if (item == 'block') setItem('block');
    else setItem('dispute')
    $("div#blockConfirmModal").fadeIn(200);
  }
  console.log(isBlock);

  const showProfile = (username) => {
    history.push(`/${username}`);
    window.location.reload();
  }

  return (
    <div>
      <div id="blockConfirmModal"
           className="depositConfirm h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
        <div className="w-11/12 h-48 bg-white absolute rounded-xl"
             style={{top: '50%', marginTop: '-6rem', left: '50%', marginLeft: '-45.83333%'}}>
          <div className="w-8/12 mx-auto h-20 mt-4">
            {
              (item == 'block')
                ?
                <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure you
                  want to block/unblock this user?</p>
                :
                <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure you
                  want to file a dispute?</p>
            }
          </div>
          <div className="w-full h-16" id="confirmBtn">
            <div className="w-full grid grid-cols-2 h-full">
              <div className="col-span-1 h-full">
                <button
                  className="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500 text-md md:text-lg bg-white"
                  onClick={() => {
                    $("div#blockConfirmModal").fadeOut(200)
                  }}>Cancel
                </button>
              </div>
              <div className="col-span-1">
                {
                  (item == 'block')
                    ?
                    <button
                      className="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                      id="confirmBtn" style={{background: '#0ac2c8'}}
                      onClick={() => handleBlock()}>
                      Yes
                    </button>
                    :
                    <button
                      className="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                      id="confirmBtn" style={{background: '#0ac2c8'}}
                      onClick={() => props.handleDispute()}>
                      Yes
                    </button>
                }
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full flex justify-between" style={{height: "70px", borderBottom: "1px solid gray"}}>
        <div style={{float: "left", marginLeft: "15px"}} className="flex-shrink-0">
          <a className="text-center float-left text-gray-500" onClick={() => props.hideDetail()}
             style={{lineHeight: "70px"}}>
            <i className="fas fa-chevron-left"/>
          </a>
          <div className="ml-10">
            <p className="text-xl font-semibold" style={{lineHeight: "70px"}}>
              Chat Detail
            </p>
          </div>
        </div>
      </div>
      <div className="w-full pt-2 pb-2" style={{borderBottom: "1px solid lightgray"}}>
        <div className="w-11/12 mx-auto">
          <p className="text-md font-semibold">People in Chat</p>
          <div className="text-sm text-indigo-500 w-11/12 mx-auto py-2">
            <div className="flex justify-start">
              <div style={{
                borderRadius: '50%',
                width: "50px",
                height: "50px",
                padding: '2px',
                background: 'linear-gradient(to right, #06ebbe, #1277d3)'
              }}>
                <div className="w-full bg-white rounded-full" style={{padding:'2px'}}>
                  <img src={`${constant.baseURL}storage/profile-image/${accountInfo.avatar}.jpg`}
                       alt={accountInfo.avatar} className="w-full rounded-full"/>
                </div>
              </div>
              <div>
                <p style={{lineHeight: "50px", marginLeft: "20px"}}>
                  <a onClick={() => showProfile(props.accountInfo.username)}>{`${accountInfo.name}(you)`}</a>
                </p>
              </div>
            </div>
          </div>
          <div className="text-sm text-indigo-500 w-11/12 mx-auto py-2">
            <div className="flex justify-start">
              <div style={{
                borderRadius: '50%',
                padding: '2px',
                background: 'linear-gradient(to right, #47afbe, #4addc4)',
                height: "50px",
                width: "50px"
              }}>
                <div className="w-full rounded-full bg-white" style={{padding:'2px'}}>
                  <img src={`${constant.baseURL}storage/profile-image/${props.contactInfo.avatar}.jpg`}
                       alt={props.contactInfo.avatar} className="w-full rounded-full"/>
                </div>
              </div>
              <div>
                <p style={{lineHeight: "50px", marginLeft: "20px"}}>
                  <a onClick={() => showProfile(props.contactInfo.username)}>{props.contactInfo.name}</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-full pt-2 pb-2" style={{borderBottom: "1px solid lightgray"}}>
        <div className="w-11/12 mx-auto">
          <p className="text-md font-semibold">Settings</p>
          <div id="dispute" className="text-sm text-gray-500 w-11/12 mx-auto py-2">
            <p className="text-sm font-bold">Dispute</p>
            <p className="text-sm text-gray-700">
              If an issue arises wherein you wish to negotiate the
              return or release of a Payment, you have the option
              to file a dispute.
            </p>
            {
              (requestInfo.status == 5)
                ?
                <button className="px-3 py-1 mt-2" style={{border: "1px solid gray"}}
                        disabled="disabled">
                  Disputed
                </button>
                :
                <button className="px-3 py-1 mt-2" style={{border: "1px solid gray"}}
                        onClick={() => showConfirm('dispute')}>
                  Dispute
                </button>
            }
          </div>
          <hr/>
          <div id="block" className="text-sm text-gray-500 w-11/12 mx-auto py-2">
            <p className="text-sm font-bold">Block</p>
            <p className="text-sm text-gray-700">
              This member will be blocked from contacting you.
            </p>
            <button className="px-3 py-1 mt-2" style={{border: "1px solid gray"}}
                    onClick={() => showConfirm('block')}>
              {isBlock ? "Unblock" : "Block"}
            </button>
          </div>
        </div>
      </div>
      <div className="w-full pt-2 pb-2" style={{borderBottom: "1px solid lightgray"}}>
        <div className="w-11/12 mx-auto">
          <p className="text-md font-semibold">Thread attachments</p>
          <div className="w-11/12 mx-auto">
            {chats.map((chat, i) => {
              if (chat.upload != "none") {
                return (
                  <a key={i} onClick={() => {
                    showImage(`${constant.baseURL}storage/upload-image/${chat.upload}.jpg`)
                  }}>
                    <div id="attachedItem" className="flex justify-start my-3"
                         style={{height: "50px"}}>
                      <div style={{fontSize: "50px"}}>
                        <i className="fas fa-file-image"/>
                      </div>
                      <div style={{margin: "10px 0 10px 20px"}}>
                        <p className="text-md text-semibold text-gray-900"
                           style={{lineHeight: "30px"}}>
                          {chat.upload}
                        </p>
                        <p className="text-sm text-gray-700" style={{lineHeight: "20px"}}>
                          {chat.created_at}
                        </p>
                      </div>
                    </div>
                  </a>
                );
              }
            })}
          </div>
        </div>
      </div>
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
              <a onClick={() => {
                $("div#imageModal").fadeOut(200)
              }} className="leading-5"><i className="fas fa-times"/></a>
            </div>
            <img src="" className="w-full"/>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailComponent;
