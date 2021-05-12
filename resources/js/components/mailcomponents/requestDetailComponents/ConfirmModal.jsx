const ConfirmModal = (props) => {
  return (
  <div id="confirmModal" className="depositConfirm h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50">
    <div className="w-11/12 h-48 bg-white absolute rounded-xl" style={{ top:'50%', marginTop:'-6rem', left:'50%', marginLeft:'-45.83333%' }}>
    <div className="w-8/12 mx-auto h-20 mt-4">
        <p className="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">  Would you like to create a deposit for this project? </p>
      </div>
      <div className="w-full h-16" id="confirmBtn">
        <div className="w-full grid grid-cols-2 h-full">
          <div className="col-span-1 h-full">
            <button className="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white" onClick={ props.confirmToggle }>Cancel</button>
          </div>
          <div className="col-span-1">
            <button className="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg" style={{ background:'#0ac2c8' }} onClick={ props.createDeposit }>Yes</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  );
}

export default ConfirmModal;