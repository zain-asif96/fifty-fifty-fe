import{l as a,w as e,o,a as t,u as n,Z as s,b as r,g as m,H as c}from"./app-db97278d.js";import{_ as u}from"./GuestLayout-861883dd.js";import f from"./PaymentInformationForm-101f3a0a.js";import p from"./TransactionSteps-25f66a90.js";import{_}from"./FiftyText-b13f5419.js";import"./FlashMessage-f6516a28.js";import"./notification-acac295e.js";import"./NewActionButton-b46bcee5.js";import"./Spinner-c1a705af.js";/* empty css                                                */import"./_plugin-vue_export-helper-c27b6911.js";import"./useAPI-5d208629.js";import"./currencies-7c039667.js";import"./currencies_countries-fbccd8be.js";import"./NewTextInput-f00b3737.js";/* empty css                                                     */import"./NewSelectInput-293ca775.js";const l=r("title",null,`
                Fifty-Fifty | Make Payment
            `,-1),d={class:"transaction-step-wrapper"},y={class:"transaction-step"},g={name:"PaymentInformation"},H=Object.assign(g,{props:{user:{required:!0,default:null,type:Object},receivingCountries:{required:!0,default:[],type:Array}},setup(i){return(v,h)=>(o(),a(u,null,{default:e(()=>[t(n(s),{title:"Fifty-Fifty | Send Money"},{default:e(()=>[l]),_:1}),r("div",d,[r("div",y,[t(p,{"current-step":"transaction-info"}),t(_,{variation:"heading-3"},{default:e(()=>[m(" Transaction information ")]),_:1}),t(c,{mode:"out-in",name:"fade"},{default:e(()=>[t(f,{receivingCountries:i.receivingCountries,user:i.user},null,8,["receivingCountries","user"])]),_:1})])])]),_:1}))}});export{H as default};