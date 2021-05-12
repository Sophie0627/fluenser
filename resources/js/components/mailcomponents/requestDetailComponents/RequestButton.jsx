import { useState } from 'react';
import constant from '../../const';
import UpdateModal from './UpdateModal';
import ConfirmModal from './ConfirmModal';
import { useHistory } from 'react-router';
import API from '../../api';

const RequestButton = (props) => {
  const { requestInfo, accountInfo, contactInfo } = props;
  const [showModal, setShowModal] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);
  const [isWaiting, setIsWaiting] = useState(false);
  const history = useHistory();

  const confirmToggle = () => {
    setShowConfirm(!showConfirm);
  }

  const popUpToggle = () => {
    setShowModal(!showModal);
    console.log("aaaaaaaaaaa");
  }

  const handleUpdateOffer = (price, currency) => {
    popUpToggle();
    props.handleUpdateOffer(price, currency);
  }

  const createDeposit = () => {
    setShowConfirm(false);
    const headers ={
        'Accept': 'application/json'
      };
      const api_token = $("meta[name=api-token]").attr('content');
      API.get('/createDeposit/' + requestInfo.request_id + '?api_token=' + api_token, {headers})
      .then((res) => {
          console.log(res.data);
        if(res.status == 200) {
            if(res.data.data == 'success') {
                history.push('/collaboration/accepted');
                window.location.reload();
            }
            if(res.data.data == 'not enough balance') {
                $("div#messageModal").fadeIn(200);
            }
        }
      })
      .catch(err => {
        console.log(err);
      });
  }

  const depositFunds = () => {
    history.push('/balance');
    window.location.reload();
  }

  const handleReject = (e) => {
    e.preventDefault();
    const headers ={
      'Accept': 'application/json'
    };
    const api_token = $("meta[name=api-token]").attr('content');
    API.get('/rejectRequest/' + requestInfo.request_id + '?api_token=' + api_token, {headers})
    .then((res) => {
      if(res.status == 200) {
        console.log(res);
        props.back();
      }
    })
    .catch(err => {
      console.log(err);
    });
  }

  const handleAccept = (e) => {
    e.preventDefault();
    const headers ={
      'Accept': 'application/json'
    };
    const api_token = $("meta[name=api-token]").attr('content');
    API.get('/acceptRequest/' + requestInfo.request_id + '?api_token=' + api_token, {headers})
    .then((res) => {
      if(res.status === 200) {
        console.log(res);
        history.push('/inbox');
        window.location.reload();
      }
    })
    .catch(err => {
      console.log(err);
    });
  }

  return (
      <div>
          {
              (isWaiting)
              ?
              <div>
                <img src={constant.baseURL + 'img/waiting.gif'} alt="waiting" className="mx-auto"/>
              </div>
              :
                <div>
                    <div id="messageModal" className="depositConfirm h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
                        <div className="w-11/12 bg-white absolute rounded-xl" style={{ top:'50%', marginTop:'-6rem', left:'50%', marginLeft:'-45.83333%' }}>
                        <div className="float-right px-2 py-2">
                            <a onClick={() => {$("div#messageModal").fadeOut(200)}}> <i className="fas fa-times"></i> </a>
                        </div>
                        <div className="w-8/12 mx-auto mt-4">
                            <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5 py-5">  Not enough balance. Click <a onClick={() => depositFunds()} className="underline text-indigo-500">HERE</a> to deposit your funds. </p>
                        </div>
                        </div>
                    </div>
                {(showModal)
                    ?
                    <UpdateModal
                    requestInfo = {requestInfo}
                    handleUpdateOffer = {handleUpdateOffer}
                    popUpToggle = {popUpToggle}
                    /> : null}

                {(showConfirm) ?
                    <ConfirmModal
                    createDeposit = {createDeposit}
                    confirmToggle = {confirmToggle}
                    /> : null}

                <div id="buttons" className="mt-16">
                {
                    (accountInfo.accountType == 'influencer')
                    ?
                    <div>
                    {
                        (requestInfo.gift == 1)
                        ?
                        <div className="flex justify-evenly">
                        <div>
                            <button className="mx-auto px-3 py-2 rounded-sm text-white text-sm md:text-md font-semibold " style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}} onClick={ handleAccept }>Accept</button>
                        </div>
                        <div>
                            <button className="mx-auto px-3 py-2 rounded-sm text-white text-sm md:text-md font-semibold " style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}} onClick={ handleReject }>Decline</button>
                        </div>
                        </div>
                        :
                        null
                    }
                    </div>
                    :
                    <div className="w-full">
                    {
                        <div>
                        {
                            <div className="flex justify-evenly">
                            {
                                (requestInfo.gift == 1)
                                ? null
                                :
                                <div>
                                <button className="mx-auto px-3 py-2 rounded-sm text-white text-sm md:text-md font-semibold " style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}onClick={ confirmToggle }>Add Deposit</button>
                                </div>
                            }
                            <div>
                                <button className="mx-auto px-3 py-2 rounded-sm text-white text-sm md:text-md font-semibold " style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}onClick={popUpToggle}>Update offer</button>
                            </div>
                            </div>
                        }
                        </div>
                    }
                    </div>
                }
                </div>
            </div>
          }
      </div>
  );
}

export default RequestButton;
