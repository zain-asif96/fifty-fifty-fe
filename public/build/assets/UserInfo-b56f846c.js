import{d as s,l as n,w as i,o as a,a as t,u as m,Z as c,b as o,g as p,H as d}from"./app-db97278d.js";import{_ as u}from"./GuestLayout-861883dd.js";import _ from"./SenderAndPayementInfoForm-fa6b5db1.js";import{_ as f}from"./FiftyText-b13f5419.js";import l from"./TransactionSteps-25f66a90.js";import"./FlashMessage-f6516a28.js";import"./notification-acac295e.js";import"./NewActionButton-b46bcee5.js";import"./Spinner-c1a705af.js";/* empty css                                                */import"./_plugin-vue_export-helper-c27b6911.js";import"./vue-tel-input-c423b696.js";import"./useAPI-5d208629.js";import"./countries-4c15b513.js";import"./currencies_countries-fbccd8be.js";import"./NewTextInput-f00b3737.js";/* empty css                                                     */import"./NewSelectInput-293ca775.js";import"./NewTextArea-c84646f3.js";const y=o("title",null,`
                Fifty-Fifty | Send Money
            `,-1),g={class:"transaction-step-wrapper"},v={class:"transaction-step"},h={name:"Main"},z=Object.assign(h,{props:{transactionId:{required:!1,type:String},user:{default:null,type:Object},commissions:{default:null,type:Object},receivingCountries:{required:!0,default:[],type:Array}},setup(r){const e=r;return s(()=>{window.sessionStorage.setItem("resend-timer",60)}),(I,w)=>(a(),n(u,null,{default:i(()=>[t(m(c),{title:"Fifty-Fifty | Send Money"},{default:i(()=>[y]),_:1}),o("div",g,[o("div",v,[t(l),t(f,{variation:"heading-3"},{default:i(()=>[p(" Enter Sender Information ")]),_:1}),t(d,{mode:"out-in",name:"fade"},{default:i(()=>[t(_,{user:e.user,commissions:e.commissions,receivingCountries:e.receivingCountries,transactionId:e.transactionId},null,8,["user","commissions","receivingCountries","transactionId"])]),_:1})])])]),_:1}))}});export{z as default};
