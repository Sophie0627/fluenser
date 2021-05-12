import { useEffect, useState } from "react";
import API from "../../api";

const UpdateModal = (props) => {

  const {requestInfo} = props;
  const [price, setPrice] = useState(0);
  const [currency, setCurrenCy] = useState('gbp');

  useEffect(() => {
    setPrice(requestInfo.amount);
    setCurrenCy(requestInfo.unit);
  }, []);

  const handlePriceChange = (e) => {
    e.preventDefault();
    setPrice(e.target.value);
  }

  const handleCurrencyChange = (e) => {
    e.preventDefault();
    setCurrenCy(e.target.value);
  }

  const updateOffer = (e) => {
    e.preventDefault();
    const headers ={
      'Accept': 'application/json'
    };
    const api_token = $("meta[name=api-token]").attr('content');
    console.log(api_token);
    if(price !== 0) {
      API.get('updateRequest/' + requestInfo.request_id + '/' + price + '/' + currency + '?api_token=' + api_token, {headers})
      .then((res) => {
        console.log(res.data);
        if(res.status == 200) {
          props.handleUpdateOffer(price, currency);
        }
      })
      .catch(err => {
        console.log(err);
      })
    }
  }

  return (
  <div id="modal" className="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50">
    <div className="w-11/12 h-48 bg-white absolute rounded-md" style={{ top:'50%', marginTop:'-6rem', left:'50%', marginLeft:'-45.83333%' }}>
      <div className="rounded-t-md h-10 pt-1" style={{ background:'linear-gradient(to right, RGB(5,235,189), RGB(19,120,212))' }}>
        <p className="text-md md:text-lg text-center text-white font-bold leading-10">Update Offer</p>
        <a className="block h-6 w-6 absolute -top-2 -right-2 rounded-full bg-white text-center" onClick={ props.popUpToggle } style={{ boxShadow:'0 0 8px #353535' }}>
          <span className="leading-6"><i className="fas fa-times"></i></span>
        </a>
      </div>

      <div className="w-11/12 mx-auto grid grid-cols-2 gap-x-4">
        <div className="col-span-1">
          <label htmlFor="price" className="block text-xs md:text-sm font-medium text-gray-700 mt-4">Project Amount<sup style={{color:'red'}}>*</sup>
          </label>
          <input type="number" value={price} id="price" className="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none" onChange={handlePriceChange} />
        </div>
        <div className="col-span-1">
          <label htmlFor="price" className="block text-xs md:text-sm font-medium text-gray-700 mt-4">Currency<sup style={{color:'red'}}>*</sup>
          </label>
          <select value={currency} id="currency" className="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none" onChange={ handleCurrencyChange }>
            <option value="usd">USD</option>
            <option value="aed">AED</option>
            <option value="aud">AUD</option>
            <option value="bgn">BGN</option>
            <option value="brl">BRL</option>
            <option value="cad">CAD</option>
            <option value="chf">CHF</option>
            <option value="czk">CZK</option>
            <option value="dkk">DKK</option>
            <option value="eur">EUR</option>
            <option value="gbp">GBP</option>
            <option value="hkd">HKD</option>
            <option value="huf">HUF</option>
            <option value="inr">INR</option>
            <option value="jpy">JPY</option>
            <option value="mxn">MXN</option>
            <option value="myr">MYR</option>
            <option value="nok">NOK</option>
            <option value="pln">PLN</option>
            <option value="ron">RON</option>
            <option value="sek">SEK</option>
            <option value="sgd">SGD</option>
          </select>
        </div>
      </div>
      <div className="w-11/12 mx-auto mt-4">
        <button className="block mx-auto px-4 py-2 rounded-sm text-white text-sm md:text-md font-semibold" style={{background:'#0ac2c8', boxShadow:'0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%)'}}onClick={updateOffer}>
          Update
        </button>
      </div>
    </div>
  </div>
  );
}

export default UpdateModal;
