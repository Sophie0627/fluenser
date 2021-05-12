import React, { useMemo, useState } from "react";
import {
  useStripe,
  useElements,
  CardNumberElement,
  CardCvcElement,
  CardExpiryElement
} from "@stripe/react-stripe-js";

import useResponsiveFontSize from "../../useResponsiveFontSize";
import API from '../../../api';
import constant from '../../../const';


const useOptions = () => {
  const fontSize = useResponsiveFontSize();
  const options = useMemo(
    () => ({
      style: {
        base: {
          fontSize,
          color: "#424770",
          letterSpacing: "0.025em",
          fontFamily: "Source Code Pro, monospace",
          "::placeholder": {
            color: "#aab7c4"
          }
        },
        invalid: {
          color: "#9e2146"
        }
      }
    }),
    [fontSize]
  );

  return options;
};

const SplitForm = (props) => {
  const [isWaiting, setIsWaiting] = useState(false);
  const stripe = useStripe();
  const elements = useElements();
  const options = useOptions();

  const handleSubmit = async event => {
    setIsWaiting(true);
    event.preventDefault();

    if (!stripe || !elements) {
      // Stripe.js has not loaded yet. Make sure to disable
      // form submission until Stripe.js has loaded.
      return;
    }

    const payload = await stripe.createPaymentMethod({
      type: "card",
      card: elements.getElement(CardNumberElement)
    });
    const headers ={
      'Accept': 'application/json'
    };
    var api_token = $("meta[name=api-token]").attr('content');

    if(payload.error) {
      console.log(payload.error.message);
    } else {
      console.log(payload.paymentMethod.id);
      console.log(props.requestID);
      API.get('createDeposit/' + payload.paymentMethod.id + '/' + props.requestID + '?api_token=' + api_token, {
        headers: headers,
      }
      ).then((res) => {
        if(res.status == 200) {
          setIsWaiting(false);
          props.afterDeposit();
        }
      });
    }
  };

  return (
    <div className="w-full md:max-w-xl bg-gray-100 rounded pb-8">
      <div className="w-11/12 mx-auto">
        <div className="text-center text-2xl font-semibold mt-8">Submit Your Payment</div>
        <hr className="mt-2" />
        <form onSubmit={handleSubmit} autoComplete="off">
          <label htmlFor="name" className="block w-full text-sm text-gray-700 mt-3">
            Name on credit card
            <input type="text" name="name" id="name" className="w-full" style={{ padding:"8px 15px" }}/>
          </label>
          <label className="block w-full mt-6 text-sm text-gray-700">
            Card number
            <CardNumberElement
              options={options}
              onReady={() => {
                console.log("CardNumberElement [ready]");
              }}
              onChange={event => {
                console.log("CardNumberElement [change]", event);
              }}
              onBlur={() => {
                console.log("CardNumberElement [blur]");
              }}
              onFocus={() => {
                console.log("CardNumberElement [focus]");
              }}
            />
          </label>
          <label className="block w-full mt-6 text-sm text-gray-700">
            Expiration date
            <CardExpiryElement
              options={options}
              onReady={() => {
                console.log("CardNumberElement [ready]");
              }}
              onChange={event => {
                console.log("CardNumberElement [change]", event);
              }}
              onBlur={() => {
                console.log("CardNumberElement [blur]");
              }}
              onFocus={() => {
                console.log("CardNumberElement [focus]");
              }}
            />
          </label>
          <label className="block w-full mt-6 text-sm text-gray-700">
            CVC
            <CardCvcElement
              options={options}
              onReady={() => {
                console.log("CardNumberElement [ready]");
              }}
              onChange={event => {
                console.log("CardNumberElement [change]", event);
              }}
              onBlur={() => {
                console.log("CardNumberElement [blur]");
              }}
              onFocus={() => {
                console.log("CardNumberElement [focus]");
              }}
            />
          </label>
          <div className="w-full mt-6">
            <button className="w-full" type="submit" disabled={!stripe}>
              {
                isWaiting
                ?
                  <img src={ constant.baseURL + 'img/loading.gif' } alt="loading" className="mx-auto" style={{width:'30px', margin:'5px'}} />
                :
                <span>
                  <i className="fas fa-lock"></i> Pay {props.price}{props.currency.toUpperCase()}
                </span>
              }
            </button>
          </div>
          <div className="w-full mt-6">
            <img src={ constant.baseURL + 'img/stripe.png' } alt="powered by stripe" style={{ width:'70%' }} className="float-right"/>
          </div>
          <div className="mt-5"></div>
        </form>
      </div>
    </div>
  );
};

export default SplitForm;
