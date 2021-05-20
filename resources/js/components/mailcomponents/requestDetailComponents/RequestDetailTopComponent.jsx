import constant from '../../const';

const RequestDetailTopComponent = (props) => {
    const {contactInfo} = props;

    return (
        <div className="w-full bg-white" style={{height: '70px'}}>
            <div style={{float: 'left', marginLeft: '15px', paddingTop: '10px'}}>
                <a className="text-center text-gray-500" onClick={props.back} style={{lineHeight: '50px'}}>
                    <i className="fas fa-chevron-left"></i>
                </a>
            </div>
            <div className="float-left flex-shrink-0 rounded-full" style={{
                width: '55px',
                height: '55px',
                margin: '10px 0',
                padding: '2px',
                marginLeft: '14px',
                background: 'linear-gradient(to right, #06ebbe, #1277d3)'
            }}>
                <div className="w-full bg-white rounded-full" style={{padding: '2px'}}>
                    <img src={constant.baseURL + 'storage/profile-image/' + props.contactInfo.avatar + '.jpg'}
                         alt={props.contactInfo.avatar} className="rounded-full"/>
                </div>
            </div>
            <p className="float-left text-lg md:text-xl text-center text-gray-500 font-bold ml-4" style={{paddingTop: '10px'}}>{contactInfo.name}
                <br/>
                <span className="text-sm md:text-md font-normal">
      {
          (contactInfo.loggedIn == 1)
              ?
              <span>Active now</span>
              :
              <span>{contactInfo.Interval}</span>
      }
                    {contactInfo.Interval}
    </span>
            </p>
        </div>
    );
}

export default RequestDetailTopComponent;
