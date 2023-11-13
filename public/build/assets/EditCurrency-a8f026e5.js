import{r as v,c as g,a as n,w as k,o as m,b as r,m as C,y as h,u as x,l as w,f as _,q as V,p as D,j as S}from"./app-db97278d.js";import{u as E}from"./useAPI-5d208629.js";import{u as q}from"./notification-acac295e.js";import{_ as u}from"./TextInput-23d29fe4.js";import{_ as R}from"./Spinner-c1a705af.js";import{_ as N}from"./Modal-54842544.js";import{_ as B}from"./_plugin-vue_export-helper-c27b6911.js";/* empty css                                                */const i=a=>(D("data-v-bb503188"),a=a(),S(),a),I={class:"flex flex-wrap gap-2 mb-3 justify-content-center"},O=i(()=>r("label",{for:""},"Rate Source",-1)),U=i(()=>r("option",{value:"world_bank"},"World Bank",-1)),j=i(()=>r("option",{value:"special"},"Special Rate",-1)),M=[U,j],$={class:"flex gap-4 items-center"},A={__name:"EditCurrency",props:{currencyData:{type:Object,required:!0},show:{type:Boolean,default:!1}},emits:["close"],setup(a,{emit:y}){const l=a,f=q(),s=E(),d=v(l.show);console.log("modal here",d.value);function c(o){console.log("this s iedit",o),y("close",o)}const p=async()=>{s.startRequest();const o=document.querySelector('meta[name="csrf-token"]').getAttribute("content");axios.defaults.headers.common["X-CSRF-TOKEN"]=o;try{const e=await axios.put("/admin/currencies/update/"+l.currencyData.value.id,l.currencyData.value);if(e.data){console.log("res",e);let t=l.currencyData.value;console.log("data",t),f.notify("Currency updated","success"),b(),c(l.currencyData.value)}}catch(e){console.log("errors",e)}finally{}},b=()=>{s.errors.value={}};return(o,e)=>(m(),g("div",null,[n(N,{close:c,isOpen:d.value,header:"Edit Currency"},{content:k(()=>[r("form",{class:"p-2 mb-2",onSubmit:e[5]||(e[5]=V((...t)=>o.submit&&o.submit(...t),["prevent"]))},[r("div",I,[n(u,{modelValue:a.currencyData.value.code,"onUpdate:modelValue":e[0]||(e[0]=t=>a.currencyData.value.code=t),label:"Currency Code",placeholder:"Currency Code",required:"",title:"code"},null,8,["modelValue"]),n(u,{modelValue:a.currencyData.value.name,"onUpdate:modelValue":e[1]||(e[1]=t=>a.currencyData.value.name=t),label:"Currency Name",placeholder:"Currency Name",required:"",title:"name"},null,8,["modelValue"]),n(u,{modelValue:a.currencyData.value.rate,"onUpdate:modelValue":e[2]||(e[2]=t=>a.currencyData.value.rate=t),label:"Currency Rate",placeholder:"Currency Rate",required:"",title:"code"},null,8,["modelValue"]),n(u,{modelValue:a.currencyData.value.special_rate,"onUpdate:modelValue":e[3]||(e[3]=t=>a.currencyData.value.special_rate=t),label:"Special Rate",placeholder:"Special Rate",required:"",title:"special_rate"},null,8,["modelValue"]),r("div",null,[O,C(r("select",{name:"rate_source",class:"w-full md:w-96 flex flex-col justify-start relative",id:"rate_source","onUpdate:modelValue":e[4]||(e[4]=t=>a.currencyData.value.rate_source=t)},M,512),[[h,a.currencyData.value.rate_source]])])]),r("div",$,[r("button",{type:"submit",onClick:p,class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Edit "),r("button",{type:"button",onClick:c,class:"text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"}," Cancel "),x(s).isLoading.value?(m(),w(R,{key:0,class:"button-spinner-center action-btn"})):_("",!0)])],32)]),_:1},8,["isOpen"])]))}},G=B(A,[["__scopeId","data-v-bb503188"]]);export{G as default};