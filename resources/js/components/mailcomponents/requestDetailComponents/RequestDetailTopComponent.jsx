import constant from '../../const';

const RequestDetailTopComponent = (props) => {
  const {contactInfo} = props;

  return (
  <div className="w-full bg-white" style={{height:'70px', paddingTop:'10px'}}>
    <div style={{float:'left', marginLeft:'15px'}}>
      <a className="text-center text-gray-500" onClick={props.back} style={{lineHeight:'50px'}}>
        <i className="fas fa-chevron-left"></i>
      </a>
    </div>
    <div className="float-left ml-4">
      <img src={constant.baseURL + 'storage/profile-image/' + contactInfo.avatar + '.jpg'} alt={contactInfo.avatar} className="rounded-full" style={{ width:'50px', height:'50px' }}/>
    </div>
    <p className="float-left text-lg md:text-xl text-center text-gray-500 font-bold ml-4">{contactInfo.name} <br/>
    <span className="text-sm md:text-md font-normal">
      {
        (contactInfo.loggedIn == 1)
        ?
        <span>Aactive now</span>
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
