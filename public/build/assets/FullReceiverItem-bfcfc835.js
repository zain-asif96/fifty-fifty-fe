import{_ as e}from"./FiftyText-b13f5419.js";import{c as s,b as l,a as t,w as a,o as m,g as n,t as u}from"./app-db97278d.js";const o={class:"receiver-item-wrapper"},b={class:"receiver-item"},d={name:"FullReceiverItem"},k=Object.assign(d,{props:{receiver:{required:!0,type:Object}},setup(r){return(f,v)=>(m(),s("div",o,[l("div",b,[t(e,{variation:"body-xl",class:"title"},{default:a(()=>[n(" Receiver Information ")]),_:1}),t(e,null,{default:a(()=>[n(" First name: "),l("b",null,u(r.receiver.first_name),1)]),_:1}),t(e,null,{default:a(()=>[n(" Last name: "),l("b",null,u(r.receiver.last_name),1)]),_:1}),t(e,null,{default:a(()=>[n(" Email: "),l("b",null,u(r.receiver.email),1)]),_:1}),t(e,null,{default:a(()=>[n(" Phone: "),l("b",null,u(r.receiver.phone),1)]),_:1}),t(e,null,{default:a(()=>[n(" Country: "),l("b",null,u(r.receiver.country),1)]),_:1}),t(e,null,{default:a(()=>{var c,i;return[n(" bank: "),l("b",null,u((i=(c=r.receiver)==null?void 0:c.bank)==null?void 0:i.label),1)]}),_:1}),t(e,null,{default:a(()=>[n(" Branch Number: "),l("b",null,u(r.receiver.branch_number),1)]),_:1}),t(e,null,{default:a(()=>[n(" Account Number: "),l("b",null,u(r.receiver.account_number),1)]),_:1}),t(e,null,{default:a(()=>[n(" Comments: "),l("b",null,u(r.receiver.banking_info),1)]),_:1})])]))}});export{k as default};