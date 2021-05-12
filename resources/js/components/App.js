import React from "react";
import ReactDOM from "react-dom";
import MailComponent from "./MailComponent";
import { BrowserRouter } from "react-router-dom";

ReactDOM.render(
  <BrowserRouter>
    <MailComponent />
  </BrowserRouter>,
  document.getElementById("mail-component")
);