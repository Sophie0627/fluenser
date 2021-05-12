const BlockBanner = () => {
    return (
        <div id="blockBanner"
             className="depositConfirm h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
            <div className="w-11/12 h-48 bg-white absolute rounded-xl"
                 style={{top: '50%', marginTop: '-6rem', left: '50%', marginLeft: '-45.83333%'}}>
                <div className="w-8/12 mx-auto h-20 mt-4">
                    <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5"> You cannot send messages.
                        This chat is blocked. </p>
                </div>
            </div>
        </div>
    );
}

export default BlockBanner;
