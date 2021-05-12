import constant from '../../const';

const ChatTopComponent = (props) => {
    return (
        <div>
            <div className="w-full flex justify-between" style={{height: '70px'}}>
                <div style={{float: 'left', marginLeft: '15px'}} className="flex-shrink-0">
                    <a className="text-center float-left text-gray-500" onClick={() => props.back()}
                       style={{lineHeight: '70px'}}>
                        <i className="fas fa-chevron-left"/>
                    </a>
                    <div className="float-left flex-shrink-0 rounded-full" style={{
                        width: '50px',
                        height: '50px',
                        margin: '10px 0',
                        padding: '2px',
                        marginLeft: '28px',
                        background: 'linear-gradient(to right, #06ebbe, #1277d3)'
                    }}>
                      <div className="w-full bg-white rounded-full" style={{padding: '2px'}}>
                        <img src={constant.baseURL + 'storage/profile-image/' + props.contactInfo.avatar + '.jpg'}
                             alt={props.contactInfo.avatar} className="rounded-full"/>
                      </div>
                    </div>
                    <div className="float-left overflow-hidden" style={{marginLeft: '12px'}}>
                        <p className="text-center text-md md:text-xl pt-2 text-gray-700 font-bold"
                           style={{lineHeight: '30px'}}>
                            {props.contactName}
                        </p>
                        <p className="text-center text-xs md:text-sm text-gray-500" style={{lineHeight: '20px'}}>
                            {
                                (props.contactInfo.loggedIn == 1)
                                    ?
                                    <span>Active now</span>
                                    :
                                    <span>Last seen {props.contactInfo.interval} ago</span>
                            }
                        </p>
                    </div>
                </div>
            </div>
            <div className="w-full text-xs text-gray-700 flex justify-between py-2 px-3"
                 style={{borderTop: "1px solid gray", borderBottom: '1px solid gray'}}>
                <div className="font-bold text-sm">
                    {props.requestInfo.title}
                </div>
                <div><i className="fas fa-ellipsis-h" onClick={() => props.showDetail()}/></div>
            </div>
        </div>
    );
}

export default ChatTopComponent;
