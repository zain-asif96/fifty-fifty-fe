import{u as Z}from"./useAPI-5d208629.js";import{_ as k,V as Y}from"./vue-tel-input-c423b696.js";import{u as W}from"./notification-acac295e.js";import x from"./ReceiverItem-bd6f56b6.js";import{r as y,k as E,d as J,c as C,b as f,a as l,u as n,w,F as Q,h as q,f as X,O as v,o as c,n as $,l as j}from"./app-db97278d.js";import{u as z}from"./useHelpers-046d81e5.js";import{c as N}from"./countries-4c15b513.js";import{_ as P}from"./NewSelectInput-293ca775.js";import{N as K}from"./NewActionButton-b46bcee5.js";import{_ as u}from"./NewTextInput-f00b3737.js";import{_ as ee}from"./NewTextArea-c84646f3.js";import"./FiftyText-b13f5419.js";import"./Spinner-c1a705af.js";/* empty css                                                */import"./_plugin-vue_export-helper-c27b6911.js";/* empty css                                                     */const re={AFG:"AF",ALA:"AX",ALB:"AL",DZA:"DZ",ASM:"AS",AND:"AD",AGO:"AO",AIA:"AI",ATA:"AQ",ATG:"AG",ARG:"AR",ARM:"AM",ABW:"AW",AUS:"AU",AUT:"AT",AZE:"AZ",BHS:"BS",BHR:"BH",BGD:"BD",BRB:"BB",BLR:"BY",BEL:"BE",BLZ:"BZ",BEN:"BJ",BMU:"BM",BTN:"BT",BOL:"BO",BES:"BQ",BIH:"BA",BWA:"BW",BVT:"BV",BRA:"BR",IOT:"IO",BRN:"BN",BGR:"BG",BFA:"BF",BDI:"BI",CPV:"CV",KHM:"KH",CMR:"CM",CAN:"CA",CYM:"KY",CAF:"CF",TCD:"TD",CHL:"CL",CHN:"CN",CXR:"CX",CCK:"CC",COL:"CO",COM:"KM",COG:"CG",COD:"CD",COK:"CK",CRI:"CR",CIV:"CI",HRV:"HR",CUB:"CU",CUW:"CW",CYP:"CY",CZE:"CZ",DNK:"DK",DJI:"DJ",DMA:"DM",DOM:"DO",ECU:"EC",EGY:"EG",SLV:"SV",GNQ:"GQ",ERI:"ER",EST:"EE",ETH:"ET",SWZ:"SZ",FLK:"FK",FRO:"FO",FJI:"FJ",FIN:"FI",FRA:"FR",GUF:"GF",PYF:"PF",ATF:"TF",GAB:"GA",GMB:"GM",GEO:"GE",DEU:"DE",GHA:"GH",GIB:"GI",GRC:"GR",GRL:"GL",GRD:"GD",GLP:"GP",GUM:"GU",GTM:"GT",GGY:"GG",GIN:"GN",GNB:"GW",GUY:"GY",HTI:"HT",HMD:"HM",VAT:"VA",HND:"HN",HKG:"HK",HUN:"HU",ISL:"IS",IND:"IN",IDN:"ID",IRN:"IR",IRQ:"IQ",IRL:"IE",IMN:"IM",ISR:"IL",ITA:"IT",JAM:"JM",JPN:"JP",JEY:"JE",JOR:"JO",KAZ:"KZ",KEN:"KE",KIR:"KI",PRK:"KP",KOR:"KR",KWT:"KW",KGZ:"KG",LAO:"LA",LVA:"LV",LBN:"LB",LSO:"LS",LBR:"LR",LBY:"LY",LIE:"LI",LTU:"LT",LUX:"LU",MAC:"MO",MKD:"MK",MDG:"MG",MWI:"MW",MYS:"MY",MDV:"MV",MLI:"ML",MLT:"MT",MHL:"MH",MTQ:"MQ",MRT:"MR",MUS:"MU",MYT:"YT",MEX:"MX",FSM:"FM",MDA:"MD",MCO:"MC",MNG:"MN",MNE:"ME",MSR:"MS",MAR:"MA",MOZ:"MZ",MMR:"MM",NAM:"NA",NRU:"NR",NPL:"NP",NLD:"NL",NCL:"NC",NZL:"NZ",NIC:"NI",NER:"NE",NGA:"NG",NIU:"NU",NFK:"NF",MNP:"MP",NOR:"NO",OMN:"OM",PAK:"PK",PLW:"PW",PSE:"PS",PAN:"PA",PNG:"PG",PRY:"PY",PER:"PE",PHL:"PH",PCN:"PN",POL:"PL",PRT:"PT",PRI:"PR",QAT:"QA",REU:"RE",ROU:"RO",RUS:"RU",RWA:"RW",BLM:"BL",SHN:"SH",KNA:"KN",LCA:"LC",MAF:"MF",SPM:"PM",VCT:"VC",WSM:"WS",SMR:"SM",STP:"ST",SAU:"SA",SEN:"SN",SRB:"RS",SYC:"SC",SLE:"SL",SGP:"SG",SXM:"SX",SVK:"SK",SVN:"SI",SLB:"SB",SOM:"SO",ZAF:"ZA",SGS:"GS",SSD:"SS",ESP:"ES",LKA:"LK",SDN:"SD",SUR:"SR",SJM:"SJ",SWE:"SE",CHE:"CH",SYR:"SY",TWN:"TW",TJK:"TJ",TZA:"TZ",THA:"TH",TLS:"TL",TGO:"TG",TKL:"TK",TON:"TO",TTO:"TT",TUN:"TN",TUR:"TR",TKM:"TM",TCA:"TC",TUV:"TV",UGA:"UG",UKR:"UA",ARE:"AE",GBR:"GB",USA:"US",UMI:"UM",URY:"UY",UZB:"UZ",VUT:"VU",VEN:"VE",VNM:"VN",VGB:"VG",VIR:"VI",WLF:"WF",ESH:"EH",YEM:"YE",ZMB:"ZM",ZWE:"ZW"},oe={class:"receiver-info-form-wrapper"},te={class:"action-buttons"},ae={key:0,class:"text-center"},ne=f("div",{class:"mt-6 mb-6 text-2xl text-green-800 font-semibold"}," Recently Added Receivers ",-1),le={class:"flex flex-wrap gap-5 max-w-3xl"},se={name:"ReceiverInfoForm"},Ie=Object.assign(se,{props:{user:{default:null,type:Object},latestReceivers:{default:[],type:Array},banks:{default:[],type:Array}},emits:["stepChanged"],setup(m,{emit:ie}){const M=m,R=W(),p=z(),a=Z(),i=y(""),A=y(!1),d=E({label:"",value:""}),e=E({first_name:"",last_name:"",phone:"",email:"",country:"",bank:"",account_number:"",branch_number:"",banking_info:""}),O=async()=>{a.startRequest();try{const t=e.id?await axios.put(`/api/receiver/${e.id}`,{...e,paymentIntentId:i.value}):await axios.post(`/api/${M.user.id}/receiver`,{...e,paymentIntentId:i.value});(t.data.id||t.data.status==="success")&&(R.notify("Receiver Information Saved","success"),D())}catch(t){R.notify("Error","error"),a.handleErrors(t)}finally{a.requestCompleted()}},D=()=>{v.get("/checkout?payment-reference-identification="+i.value+"&country="+d.value.value)},_=()=>{v.get("/transaction-info")},g=t=>{d.value=N.find(r=>r.value===t.country||r.value===re[t.country]),Object.assign(e,t)},F=t=>{var s;const r=(s=e.phone)==null?void 0:s.slice(t.dialCode.length+1);e.phone="+"+t.dialCode+r},H=()=>{e.country=M.user.handled_transaction.user.country};return J(()=>{var r;i.value=p.getURLParam("payment-reference-identification"),console.log("paymentIntentID.value",i.value);const t=p.getURLParam("country");console.log(t),d.value=N.find(s=>s.value===t),e.country=(r=d.value)==null?void 0:r.value,A.value=!!M.user.transaction_id,A.value&&H()}),(t,r)=>{var s,S,B,G,L,T,I,V,b;return c(),C("div",null,[f("div",oe,[l(u,{class:"fifty-form-input",modelValue:e.first_name,"onUpdate:modelValue":r[0]||(r[0]=o=>e.first_name=o),errors:(s=n(a).errors.value)==null?void 0:s.first_name,label:"First Name",placeholder:"John",required:"",title:"first_name"},null,8,["modelValue","errors"]),l(u,{class:"fifty-form-input",modelValue:e.last_name,"onUpdate:modelValue":r[1]||(r[1]=o=>e.last_name=o),errors:(S=n(a).errors.value)==null?void 0:S.last_name,label:"Last Name",placeholder:"Doe",required:"",title:"last_name"},null,8,["modelValue","errors"]),l(u,{class:"fifty-form-input",modelValue:e.email,"onUpdate:modelValue":r[2]||(r[2]=o=>e.email=o),errors:(B=n(a).errors.value)==null?void 0:B.email,label:"Email",placeholder:"john@example.com",title:"email"},null,8,["modelValue","errors"]),l(k,{errors:(G=n(a).errors.value)==null?void 0:G.phone,required:!1,label:"Phone Number",title:"phone",class:"fifty-form-input"},{default:w(()=>{var o,U;return[l(n(Y),{id:"exampleFormControlInput1",ref:"input",modelValue:e.phone,"onUpdate:modelValue":r[3]||(r[3]=h=>e.phone=h),class:$([{"error-border":((U=(o=n(a).errors.value)==null?void 0:o.phone)==null?void 0:U.length)>0},"form-control block w-full px-0 py-0 text-lg font-normal h-10 text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-linear m-0 focus:text-gray-700 focus:bg-white focus:border-indigo-300 focus:outline-none"]),defaultCountry:n(p).getURLParam("country"),inputOptions:{placeholder:"123456789"},onlyCountries:A.value?[e.country]:[],mode:"international",onCountryChanged:F},null,8,["modelValue","class","defaultCountry","onlyCountries"])]}),_:1},8,["errors"]),l(P,{class:"fifty-form-input",modelValue:e.country,"onUpdate:modelValue":r[4]||(r[4]=o=>e.country=o),errors:(L=n(a).errors.value)==null?void 0:L.country,options:n(N),disabled:"",label:"Country",placeholder:"Country",required:"",title:"country",type:"text"},null,8,["modelValue","errors","options"]),l(P,{class:"fifty-form-input",modelValue:e.bank_id,"onUpdate:modelValue":r[5]||(r[5]=o=>e.bank_id=o),errors:(T=n(a).errors.value)==null?void 0:T.bank_id,options:m.banks,label:"International Bank","label-accessor":"label",placeholder:"International Bank",required:"",title:"bank",type:"text","value-accessor":"id"},null,8,["modelValue","errors","options"]),l(u,{class:"fifty-form-input",modelValue:e.account_number,"onUpdate:modelValue":r[6]||(r[6]=o=>e.account_number=o),errors:(I=n(a).errors.value)==null?void 0:I.account_number,label:"Account Number",placeholder:"123456789",required:"",title:"account_number"},null,8,["modelValue","errors"]),l(u,{class:"fifty-form-input",modelValue:e.branch_number,"onUpdate:modelValue":r[7]||(r[7]=o=>e.branch_number=o),errors:(V=n(a).errors.value)==null?void 0:V.branch_number,label:"Branch Number",placeholder:"123456789",title:"branch_number"},null,8,["modelValue","errors"]),l(ee,{modelValue:e.banking_info,"onUpdate:modelValue":r[8]||(r[8]=o=>e.banking_info=o),errors:(b=n(a).errors.value)==null?void 0:b.banking_info,label:"Additional Information / Comments",placeholder:"I am open to different payment options...",title:"banking_info"},null,8,["modelValue","errors"]),f("div",te,[l(K,{reversed:!0,title:"Back",onClick:_}),l(K,{isLoading:n(a).isLoading.value,title:"Continue",onClick:O},null,8,["isLoading"])])]),m.latestReceivers.length>0?(c(),C("div",ae,[ne,f("div",le,[(c(!0),C(Q,null,q(m.latestReceivers,o=>(c(),j(x,{key:o.id,receiver:o,useSavedReceiver:g},null,8,["receiver"]))),128))])])):X("",!0)])}}});export{Ie as default};
