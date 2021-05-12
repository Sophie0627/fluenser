import React from "react";
import {
  Switch,
  Route,
  Redirect,
  useLocation,
  useHistory
} from "react-router-dom";
import SplitForm from './demos/SplitForm';
import IdealBankForm from './demos/IdealBankForm';
import IbanForm from './demos/IbanForm';
import FpxBankForm from './demos/FpxBankForm';
import '../styles.css';

const demos = [
  {
    path: "/split-card-elements",
    label: "Pay Via Card",
    component: SplitForm
  },
  {
    path: "/ideal-bank-element",
    label: "Pay Via IdealBank",
    component: IdealBankForm
  },
  {
    path: "/iban-element",
    label: "Pay Via Iban",
    component: IbanForm
  },
  {
    path: "/fpx-bank-element",
    label: "Pay Via FpxBank",
    component: FpxBankForm
  },
];

const ElementDemos = ( props ) => {
  const location = useLocation();
  const history = useHistory();

  return (
    <div className="DemoWrapper">
      <div className="DemoPickerWrapper">
        <select
          className="DemoPicker"
          value={location.pathname}
          onChange={event => {
            history.push(event.target.value);
          }}
          hidden
        >
          {demos.map(({ path, label }) => (
            <option key={path} value={'/request' + path}>
              {label}
            </option>
          ))}
        </select>
      </div>
      <Switch>
        <Redirect to={'/request' + demos[0].path} from="/request" exact />
        {demos.map(({ path, component: Component }) => (
          <Route key={path} path={'/request' + path}>
            <div className="Demo">
              <Component 
                price = {props.price}
                currency = {props.currency}
                requestID = { props.requestID }
                afterDeposit = {() => props.afterDeposit()}
              />
            </div>
          </Route>
        ))}
      </Switch>
    </div>
  );
};
export default ElementDemos;
