import{k as b,r as g,c as y,a as i,w as v,o as _,b as r,q as x}from"./app-db97278d.js";import{u as k}from"./useAPI-5d208629.js";import{u as h}from"./notification-acac295e.js";import{_ as w}from"./Modal-54842544.js";import{_ as m}from"./TextInput-23d29fe4.js";import{_ as V}from"./_plugin-vue_export-helper-c27b6911.js";const D={class:"flex flex-wrap gap-2 mb-3 justify-content-center"},E={__name:"Edit",props:{commissionsData:{type:Object,required:!0},show:{type:Boolean,default:!1}},emits:["close"],setup(d,{emit:c}){const s=d,u=h(),n=k();console.log("commissionsData",s.commissionsData);const e=b({from:s.commissionsData.value.from,to:s.commissionsData.value.to,amount:s.commissionsData.value.amount}),p=g(s.show);function l(o){c("close",o)}const f=async()=>{n.startRequest(),console.log("commissionsData",s.commissionsData.value.id,e);try{const o=await axios.put("/admin/commission/"+s.commissionsData.value.id,e);console.log("res",o),o.data&&(u.notify("Commission updated","success"),l(e))}catch(o){console.log("errors",o),u.notify("Error","error"),n.handleErrors(o)}finally{n.requestCompleted()}};return(o,t)=>(_(),y("div",null,[i(w,{close:l,isOpen:p.value,header:"Amount commissions"},{content:v(()=>[r("form",{class:"p-2 mb-2",onSubmit:t[3]||(t[3]=x((...a)=>o.submit&&o.submit(...a),["prevent"]))},[r("div",D,[i(m,{modelValue:e.from,"onUpdate:modelValue":t[0]||(t[0]=a=>e.from=a),label:"From",placeholder:"From",required:"",title:"code"},null,8,["modelValue"]),i(m,{modelValue:e.to,"onUpdate:modelValue":t[1]||(t[1]=a=>e.to=a),label:"To",placeholder:"To",required:"",title:"code"},null,8,["modelValue"]),i(m,{modelValue:e.amount,"onUpdate:modelValue":t[2]||(t[2]=a=>e.amount=a),label:"Amount",placeholder:"Amount",required:"",title:"code"},null,8,["modelValue"])]),r("div",{class:"flex gap-4 items-center"},[r("button",{type:"submit",onClick:f,class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Edit "),r("button",{type:"button",onClick:l,class:"text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"}," Cancel ")])],32)]),_:1},8,["isOpen"])]))}},U=V(E,[["__scopeId","data-v-460baded"]]);export{U as default};
