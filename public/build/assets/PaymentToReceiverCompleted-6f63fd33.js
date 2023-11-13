import{_ as C}from"./Modal-54842544.js";import{u as x}from"./useAPI-5d208629.js";import{u as S}from"./notification-acac295e.js";import{_}from"./FiftyText-b13f5419.js";import{N as w}from"./NewActionButton-b46bcee5.js";import{_ as O}from"./_plugin-vue_export-helper-c27b6911.js";import{o as a,c,b as s,r as B,a as n,w as r,u as P,g as m,l as N,n as T,t as z,D}from"./app-db97278d.js";const M={transaction_initialized:1,pairing_pending:2,pairing_complete:3,payment_to_receiver_pending:4,payment_to_receiver_complete:5,payment_to_receiver_confirmed:6,payment_to_opposite_receiver_pending:7,payment_to_opposite_receiver_complete:8,transaction_completed:10,transaction_cancelled:0},ae={transaction_initialized:1,pairing_complete:2,payment_to_opposite_receiver_confirmed:3,payment_to_receiver_complete:4,payment_to_receiver_confirmed:5,transaction_completed:6,transaction_cancelled:0},R={name:"SuccessIcon"},j={"aria-hidden":"true",class:"w-5 h-5",fill:"currentColor",viewBox:"0 0 20 20",xmlns:"http://www.w3.org/2000/svg"},E=s("path",{"clip-rule":"evenodd",d:"M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z","fill-rule":"evenodd"},null,-1),H=[E];function I(t,f,l,u,y,i){return a(),c("svg",j,H)}const L=O(R,[["render",I]]),V=s("div",{class:"track-step-icon w-3 h-3 mt-1.5 -left-1.5 border border-white"},null,-1),q={class:"receiver-action-buttons"},U={class:"p-6"},A={key:0},F={key:1},G=["src"],J={key:0,class:"confirmed-button"},K={name:"PaymentToReceiverCompleted"},Q=Object.assign(K,{props:{transaction:{type:Object,required:!0},isHidden:{type:Boolean,default:!1}},emits:["transactionUpdated"],setup(t,{emit:f}){const l=t,u=e=>{const o=e;window.open(o,"_blank")};function y(e){let o=!1;return e.split(".")[1]==="pdf"&&(o=!0),o}const i=x(),v=S(),d=B(!1),$=()=>{d.value=!1},b=()=>{l.isHidden||(d.value=!0)},k=async()=>{if(!l.isHidden){i.startRequest();try{const e=await axios.post("/api/confirm-payment-to-receiver",{transactionId:l.transaction.id});console.log(e),e.data.status==="success"&&(v.notify("Payment to receiver confirmed","success"),f("transactionUpdated",e.data.transaction))}catch(e){i.handleErrors(e),v.notify("Error confirming payment...","error")}finally{i.requestCompleted()}}};return(e,o)=>(a(),c("li",{class:T({"opacity-30":t.isHidden})},[V,n(_,{class:"mb-2"},{default:r(()=>[m(z(t.transaction.payment_to_receiver_completed_at),1)]),_:1}),n(_,{variation:"body-xl",color:"dark"},{default:r(()=>[m(" Payment Complete ")]),_:1}),n(_,null,{default:r(()=>[D(e.$slots,"default")]),_:3}),s("div",q,[n(C,{close:$,isOpen:d.value,header:"Proof Of Payment"},{button:r(()=>[n(w,{onClick:b,title:"View Proof"})]),content:r(()=>{var p,h;return[s("div",U,[y(`${(p=t.transaction.opposite_transaction)==null?void 0:p.payment_intent.payment_proof}`)?(a(),c("div",A,[s("a",{onClick:o[0]||(o[0]=W=>{var g;return u(`${(g=t.transaction.opposite_transaction)==null?void 0:g.payment_intent.payment_proof}`)}),href:"#"},"Download PDF")])):(a(),c("div",F,[s("img",{src:`${(h=t.transaction.opposite_transaction)==null?void 0:h.payment_intent.payment_proof}`,alt:"proof of payment"},null,8,G)]))])]}),_:1},8,["isOpen"]),P(M)[t.transaction.status]>5?(a(),c("div",J,[n(L,{class:"icon"}),m(" Payment Confirmed ")])):(a(),N(w,{key:1,isLoading:P(i).isLoading.value,onClick:k,title:"Confirm Payment Received",reversed:!0},null,8,["isLoading"]))])],2))}}),se=Object.freeze(Object.defineProperty({__proto__:null,default:Q},Symbol.toStringTag,{value:"Module"}));export{se as P,Q as _,ae as o,M as t};
