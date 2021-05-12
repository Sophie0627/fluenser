import React, { useMemo } from "react";
import {
  useStripe,
  useElements,
  IdealBankElement
} from "@stripe/react-stripe-js";

import useResponsiveFontSize from "../../useResponsiveFontSize";
import API from '../../../api';

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
          },
          padding: "10px 14px"
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

const IdealBankForm = (props) => {
  const stripe = useStripe();
  const elements = useElements();
  const options = useOptions();

  const handleSubmit = async event => {
    event.preventDefault();

    if (!stripe || !elements) {
      // Stripe.js has not loaded yet. Make sure to disable
      // form submission until Stripe.js has loaded.
      return;
    }

    const payload = await stripe.createPaymentMethod({
      type: "ideal",
      ideal: elements.getElement(IdealBankElement),
      billing_details: {
        name: event.target.name.value
      }
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
          props.afterDeposit();
        }
      });
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <label>
        Name
        <input name="name" type="text" placeholder="Jane Doe" required />
      </label>
      <label>
        iDEAL Bank
        <IdealBankElement
          className="IdealBankElement"
          options={options}
          onReady={() => {
            console.log("IdealBankElement [ready]");
          }}
          onChange={event => {
            console.log("IdealBankElement [change]", event);
          }}
          onBlur={() => {
            console.log("IdealBankElement [blur]");
          }}
          onFocus={() => {
            console.log("IdealBankElement [focus]");
          }}
        />
      </label>
      <button type="submit" disabled={!stripe}>
        Pay
      </button>
    </form>
  );
};

export default IdealBankForm;
