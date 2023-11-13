import{u as g}from"./useAPI-5d208629.js";import{u as k}from"./notification-acac295e.js";import{_}from"./TextInput-23d29fe4.js";import{_ as v}from"./SelectInput-941874a0.js";import{_ as B}from"./Spinner-c1a705af.js";import{k as h,d as x,c as C,b as o,a as p,u as s,l as E,f as V,o as y}from"./app-db97278d.js";/* empty css                                                */const q={class:"border-gray-400 border rounded-lg p-6 mb-8"},w={class:"grid gap-6 mb-10 md:grid-cols-2"},N={class:"flex gap-4 items-center"},U={name:"EditBank"},M=Object.assign(U,{props:{countries:{type:Array,required:!0},editedBank:{type:Object,required:!0}},emits:["bankEdited","endEdit"],setup(l,{emit:i}){const t=l,r=g(),u=k(),c=()=>{r.errors.value={},i("endEdit")},f=async()=>{r.startRequest();try{(await axios.put("/admin/banks/update/"+t.editedBank.value.id,e)).data&&(u.notify("Bank updated","success"),c(),i("bankEdited",e))}catch(n){u.notify("Error","error"),r.handleErrors(n)}finally{r.requestCompleted()}},e=h({});return x(()=>{e.id=t.editedBank.value.id,e.country=t.editedBank.value.country,e.label=t.editedBank.value.label,e.country_id=t.editedBank.value.country_id}),(n,a)=>{var b,m;return y(),C("div",null,[o("form",q,[o("div",w,[p(_,{modelValue:e.label,"onUpdate:modelValue":a[0]||(a[0]=d=>e.label=d),errors:(b=s(r).errors.value)==null?void 0:b.label,label:"Bank",placeholder:"Royal Bank Canada",required:"",title:"label"},null,8,["modelValue","errors"]),p(v,{modelValue:e.country_id,"onUpdate:modelValue":a[1]||(a[1]=d=>e.country_id=d),errors:(m=s(r).errors.value)==null?void 0:m.country_id,options:l.countries,label:"Choose a Country",required:"",placeholder:" Country ",title:"country_id",type:"text","value-accessor":"id"},null,8,["modelValue","errors","options"])]),o("div",N,[o("button",{onClick:f,type:"button",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Update "),o("button",{type:"button",onClick:c,class:"text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"}," Cancel "),s(r).isLoading.value?(y(),E(B,{key:0,class:"button-spinner-center action-btn"})):V("",!0)])])])}}});export{M as default};
