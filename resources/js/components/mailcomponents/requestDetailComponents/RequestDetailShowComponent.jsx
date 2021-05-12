import constant from '../../const';

const RequestDetailShowComponent = (props) => {
    const {requestInfo, datetime} = props;

    const showImage = (src) => {
        $("div#imageModal img").attr("src", src);
        $("div#imageModal").fadeIn(200);
    }

    return (
        <div id="requestdetail absolute top-1">
            <p className="text-center text-xs md:text-sm text-gray-400">{datetime}</p>
            <div className="w-10/12 mx-auto bg-white py-1 py-2">
                <p className="text-center text-gray-700 text-sm md:text-md">
                    {requestInfo.content}
                </p>
                {
                    (requestInfo.gift == 1) ?
                        <p className="text-gray-500 text-xs md:text-sm ml-2">
                            Offer: <span className="text-gray-600 font-bold">Gift</span>
                        </p>
                        :
                        <p className="text-gray-500 text-xs md:text-sm ml-2">
                            Offer:
                            <span className="text-gray-600 font-bold">{requestInfo.amount + (requestInfo.unit).toUpperCase()}</span>
                        </p>
                }
                <div id="reqeustImages" className="mt-2">
                    {
                      (requestInfo.images == 'none') ? null :
                        requestInfo.images.map((requestInfo, key) => {
                            return (
                                <div key={key} className="float-left ml-2">
                                    <a onClick={() => showImage(`${constant.baseURL}storage/task-image/${requestInfo.image}.jpg`)}>
                                        <img src={`${constant.baseURL}storage/task-image/${requestInfo.image}.jpg`}
                                             alt="" style={{width: '50px', height: '50px'}}/>
                                    </a>
                                    <div className="clearfix"/>
                                </div>
                            );
                        })
                    }
                    <div className="clearfix"/>
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
                            <a onClick={() => {$("div#imageModal").fadeOut(200)}} className="leading-5"><i className="fas fa-times"/></a>
                        </div>
                        <img src="" className="w-full"/>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default RequestDetailShowComponent;
