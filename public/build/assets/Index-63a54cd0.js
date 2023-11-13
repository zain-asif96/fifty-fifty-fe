import{r as g,d as C,c as y,a as u,w as _,u as t,F as w,o as f,Z as V,b as e,t as a,i as I,e as P,f as z,n as d,g as n,h as q,z as x,O as v,p as T,j}from"./app-db97278d.js";import{_ as A}from"./AdminLayout-8e0f8360.js";import{P as F}from"./Pagination-e186959c.js";import{u as N}from"./sorting-acdd0b76.js";import{_ as O}from"./TextInput-23d29fe4.js";import{_ as R}from"./_plugin-vue_export-helper-c27b6911.js";import"./ResponsiveNavLink-3932dd1a.js";import"./notification-acac295e.js";import"./FlashMessage-f6516a28.js";import"./CustomSidebar-7abc467c.js";import"./SidebarElement-2b51bfcd.js";const S=m=>(T("data-v-a1f95b4e"),m=m(),j(),m),B=S(()=>e("title",null,`
            Transactions
        `,-1)),K={class:"ml-4 md:ml-8 mr-4 md:mr-8"},L={class:"mt-16 mb-8 text-xl flex items-center justify-between"},U=S(()=>e("div",null," Transactions ",-1)),D={class:"text-sm"},E={class:"flex items-end gap-3"},M={class:"relative overflow-x-auto shadow-md sm:rounded-lg"},Z={class:"w-full text-sm text-left text-gray-500 dark:text-gray-400"},G={class:"text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"},H={class:"fw-100"},J={class:"fw-100"},Q={class:"fw-100"},W={class:"fw-100"},X={class:"fw-100"},Y={class:"fw-100"},ee={class:"fw-100"},te={class:"px-6 py-4"},se={class:"px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white",scope:"row"},ae={class:"px-6 py-4"},le={class:"px-6 py-4"},oe={class:"uppercase"},re={class:"px-6 py-4 capitalize"},ne={class:"px-6 py-4 capitalize"},ce={class:"px-6 py-4 capitalize"},ie={name:"Transactions/Index"},ue=Object.assign(ie,{props:{transactions:{required:!0,type:Object}},setup(m){const p=m;let o=g("");var c=g(!1),h=g(1);const l=N(),b=i=>{o.value=o.value!=null?o.value:"",c.value=!0,l.sortValues(i),v.visit(`?page=${h.value}&q=${o.value}&column=${l.column}&type=${l.type}`)&&(c.value=!1)},k=()=>{v.visit(`?page=${h.value}&q=${o.value}&column=${l.column}&type=${l.type}`)},$=()=>{v.visit("?q=")};return C(()=>{o.value=new URLSearchParams(window.location.search).get("q");let i=new URLSearchParams(window.location.search).get("page");h.value=i??1}),(i,r)=>(f(),y(w,null,[u(t(V),{title:"Transactions"},{default:_(()=>[B]),_:1}),u(A,null,{default:_(()=>[e("div",K,[e("div",L,[U,e("div",D," Page: "+a(p.transactions.current_page)+" | total: "+a(p.transactions.total)+" | from: "+a(p.transactions.from)+", to: "+a(p.transactions.to),1)]),e("div",E,[u(O,{modelValue:t(o),"onUpdate:modelValue":r[0]||(r[0]=s=>I(o)?o.value=s:o=s),class:"mb-8",label:"Search by",placeholder:"Search",title:"searchValue",onKeyup:P(k,["enter"])},null,8,["modelValue","onKeyup"]),e("button",{onClick:k,type:"button",class:"mb-8 flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"}," Search "),t(o)?(f(),y("button",{key:0,onClick:$,type:"button",class:"mb-8 flex items-center text-blue-700 bg-white border border-blue-700 hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"}," Clear ")):z("",!0)]),e("div",M,[e("table",Z,[e("thead",G,[e("tr",null,[e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col",onClick:r[1]||(r[1]=s=>b("created_at"))},[n(" Initialized "),e("span",H,a(t(l).column=="created_at"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col"},[n(" Sender "),e("span",J,a(t(l).column=="user"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col"},[n(" Receiver "),e("span",Q,a(t(l).column=="receiver"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col"},[n(" Amount "),e("span",W,a(t(l).column=="amount"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col",onClick:r[2]||(r[2]=s=>b("status"))},[n(" status "),e("span",X,a(t(l).column=="status"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col",onClick:r[3]||(r[3]=s=>b("type"))},[n(" type "),e("span",Y,a(t(l).column=="type"?"("+t(l).type+")":""),1)],2),e("th",{class:d(["px-6 py-3",t(c)?"disabled":"clickable"]),scope:"col",onClick:r[4]||(r[4]=s=>b("payment_status"))},[n(" Payment Status "),e("span",ee,a(t(l).column=="payment_status"?"("+t(l).type+")":""),1)],2)])]),e("tbody",null,[(f(!0),y(w,null,q(p.transactions.data,s=>(f(),y("tr",{key:s.id,class:"bg-white border-b dark:bg-gray-900 dark:border-gray-700"},[e("td",te,a(s.created_at),1),e("th",se,[u(t(x),{href:i.route("single.user.page",s.user.id),class:"text-blue-700 hover:text-blue-900 hover:underline"},{default:_(()=>[n(a(s.user.first_name)+" "+a(s.user.last_name)+" ("+a(s.user.country)+") ",1)]),_:2},1032,["href"])]),e("td",ae,[u(t(x),{href:i.route("single.receiver.page",s.receiver.id),class:"text-blue-700 hover:text-blue-900 hover:underline"},{default:_(()=>[n(a(s.receiver.first_name)+" "+a(s.receiver.last_name)+" ("+a(s.receiver.country)+") ",1)]),_:2},1032,["href"])]),e("td",le,[u(t(x),{href:i.route("payment.intent.page",s.payment_intent.id),class:"text-blue-700 hover:text-blue-900 hover:underline"},{default:_(()=>[n(a(parseFloat(s.payment_intent.amount/100).toFixed(2))+" ",1),e("span",oe," ("+a(s.payment_intent.currency)+") ",1)]),_:2},1032,["href"])]),e("td",re,a(s.status.replaceAll("_"," ")),1),e("td",ne,a(s.type.replaceAll("_"," ")),1),e("td",ce,a(s.payment_status.replaceAll("_"," ")),1)]))),128))])])]),u(F,{links:p.transactions.links},null,8,["links"])])]),_:1})],64))}}),ke=R(ue,[["__scopeId","data-v-a1f95b4e"]]);export{ke as default};