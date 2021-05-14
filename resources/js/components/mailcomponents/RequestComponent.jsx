import React, { Component, useEffect, useState } from 'react';
import API from '../api';
import constant from '../const';
import $ from 'jquery';
import {useHistory} from "react-router-dom";

const RequestComponent =(props) => {
  const [user_id, setUserID] = useState(0);
  const [requests, setRequests] = useState([]);
  const [showRequests, setShowRequests] = useState([]);
  const [isWaiting, setIsWaiting] = useState(true);
  const [requestSearch, setRequestSearch] = useState("");
  const [update, setUpdate] = useState(true);
  const history = useHistory();

  const onSearch = (e) => {
    e.preventDefault();
    const keyword = requestSearch;
    const tempRequests = requests;
    const newRequests = [];
    tempRequests.map((request, i) => {
      console.log(request.accountInfo[0].name.toUpperCase().search(keyword.toUpperCase()));
      if(request.accountInfo[0].name.toUpperCase().search(keyword.toUpperCase()) != -1) {
        newRequests.push(request);
      }
    });
    setShowRequests(newRequests);
  }

  const handleOnSearchChange = (e) => {
    setRequestSearch(e.target.value);
  }
  const handleReject = (e, request_id) => {
    e.preventDefault();
    const headers ={
      'Accept': 'application/json'
    };
    const api_token = $("meta[name=api-token]").attr('content');
    API.get('/rejectRequest/' + request_id + '?api_token=' + api_token, {headers})
      .then((res) => {
        if(res.status == 200) {
          console.log(res);
          window.location.reload();
        }
      })
      .catch(err => {
        console.log(err);
      });
  }

  const handleViewProfile = (e, username) => {
    e.preventDefault();
    history.push('/' + username);
    window.location.reload();
  }

  useEffect(() => {
    let isMount = false;
    $('nav').show();
    // request
    const headers ={
      'Accept': 'application/json'
    };
    let requests;
    const api_token = $("meta[name=api-token]").attr('content');
    API.get('request?api_token=' + api_token, {
      headers: headers
    }).then((response) => {
      if(!isMount) {
        setIsWaiting(false);
        if(response.status == 200) {
          console.log('-------------');
          console.log(response.data);
          requests = response.data.data;
          setRequests(requests);
          setShowRequests(requests);
          setUserID(response.data.user_id);
          setUpdate(update);
        }
      }
    }).catch(error => {
      console.log(error);
    })
    console.log("mounted component message");

    // Pusher
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('da7cd3b12e18c9e2e461', {
      cluster: 'eu',
    });

    var channel = pusher.subscribe('fluenser-channel');
    channel.bind('fluenser-event', function(data) {
      console.log('pusher_data');
      if(data.trigger == 'request') {
        console.log(data);
        if(data.influencer_id == user_id) {
          console.log(data.request);
          var requests = requests;
          requests.unshift(data.request);
          console.log(requests);
          setRequests(requests);
          setUpdate(update);
        }
      }
    });

    props.selectTab('requests');

    return() => {
      isMount = true;
    }
  }, [update]);

  if(isWaiting) {
    return (
      <div className="max-w-sm mx-auto py-10 text-center">
        <img src={constant.baseURL + 'img/waiting.gif'} alt="waiting" className="mx-auto"/>
      </div>
    )
  } else {
    var containerHeight = innerHeight - 230;
    return (
      <div>
        <div id="requestSearch">
          <div className="py-2 w-11/12 mx-auto mt-3 relative">
            <input type="text" value={requestSearch} id="requestSearch" style={{ height:'45px',  }} className="w-full px-6 py-1 rounded-full bg-gray-100 border-none" onChange={handleOnSearchChange} placeholder="Search here..."/>
            <button className="absolute right-4 text-gray-500" style={{height:'45px'}} onClick={onSearch}>
              <i className="fas fa-search"></i>
            </button>
          </div>
        </div>
        {
          (requests.length == 0)
          ?
          <div className="max-w-sm mx-auto text-center py-10">
            <p className="text-center">
              No request to show
            </p>
          </div>
          :
          <div className="pt-2 mt-3 w-11/12 mx-auto rounded" style={{boxShadow:'0 0 3px 3px #eee'}}>
          <div style={{ height:containerHeight, overflow:'auto'}}>
            {
              showRequests.map((request, i)=>{
                return(
                  <div key={i} className="w-11/12 mx-auto" id={ request.id }>
                    <div className='pt-7'>
                        <div className="float-left flex-shrink-0 rounded-full" style={{
                            width: '55px',
                            height: '55px',
                            margin: '10px 0',
                            padding: '2px',
                            marginLeft: '28px',
                            background: 'linear-gradient(to right, #06ebbe, #1277d3)'
                        }}>
                            <div className="w-full bg-white rounded-full" style={{padding: '2px'}}>
                            <img src={ constant.baseURL + 'storage/profile-image/' + request.accountInfo[0].avatar + '.jpg' } alt={ request.accountInfo[0].avatar } className="rounded-full" style={{width:'100%'}}/>
                            </div>
                        </div>
                      <div style={{marginLeft:'70px'}}>
                        <p className="text-md md:text-lg font-bold relative">
                          { request.accountInfo[0].name }
                          {
                            (request.unread)
                            ?
                            <span className="block absolute -top-2 right-1 text-xs font-light h-2 w-2 rounded-full bg-red-500 text-white"></span>
                            :
                            <span className="block absolute -top-2 right-1 text-xs font-light h-2 w-2 rounded-full bg-red-500 text-white" style={{display:'none'}}></span>
                          }
                        </p>
                      </div>
                      <div style={{margin:'0 0 0 70px'}}>
                        <p className="text-xs md:text-sm text-gray-500 overflow-hidden" style={{height:'17px'}}>
                          { request.requestContent.content }
                        </p>
                      </div>
                      <div style={{marginLeft:'70px'}}>
                        {
                          (request.requestContent.gift == 1)
                          ?
                          <p className="text-xs md:text-sm text-gray-500">
                            Offer: <span className="text-black text-sm font-bold">Gift</span>
                          </p>
                          :
                            (request.requestContent.amount == 0)
                            ?
                              null
                            :
                            <p className="text-xs md:text-sm text-gray-500">
                              Offer: <span className="text-black text-sm font-bold">{request.requestContent.amount + ' ' + request.requestContent.unit.toUpperCase()}</span>
                            </p>
                        }
                      </div>
                      <div className="clearfix"></div>
                    </div>
                    <div className="w-full mt-3 mb-4">
                      {
                        (request.requestContent.images == 'none')
                        ? null
                        :
                        request.requestContent.images.map((image, i) =>(
                          <div key={i} className="float-left ml-2" style={{ width:'50px', height:'50px' }}>
                            <img src={constant.baseURL + 'storage/task-image/' + image.image + '.jpg'} alt={image.image} className="w-full"/>
                          </div>
                        ))
                      }
                    </div>
                    <div className="clearfix"></div>
                    {
                      (request.requestContent.gift == 0 && request.requestContent.amount == 0)
                        ?
                        <div className="w-full grid grid-cols-2 gap-x-5">
                          <div className="col-span-1">
                            <a className="block text-center text-white w-full py-2 my-3 font-semibold text-sm md:text-md rounded-sm" onClick={(e) => handleViewProfile(e, request.accountInfo[0].username)} style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}>View Profile</a>
                          </div>
                          <div className="col-span-1">
                            <a className="block text-center text-white w-full py-2 my-3 font-semibold text-sm md:text-md rounded-sm" onClick={(e) => handleReject(e, request.requestContent.request_id)} style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}>Decline</a>
                          </div>
                        </div>
                        :
                        <div className="w-full">
                          <a className="block text-center text-white w-full py-2 my-3 font-semibold text-sm md:text-md rounded-sm" onClick={() => props.onRequestClick(request.id)} style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}> Read More</a>
                        </div>
                    }
                    <hr className="mt-7"/>
                  </div>
                );
              })
            }
          </div>
        </div>
        }
      </div>
    )
  }
}

export default RequestComponent;
