(()=>{"use strict";var e,t={450:(e,t,o)=>{const l=window.wp.blocks;var n=o(609);const a=window.wp.i18n,c=window.wp.blockEditor,i=window.wp.components,r=window.wp.primitives;var s=o(848);const d=(0,s.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,s.jsx)(r.Path,{d:"M9 9v6h11V9H9zM4 20h1.5V4H4v16z"})}),y=(0,s.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,s.jsx)(r.Path,{d:"M12.5 15v5H11v-5H4V9h7V4h1.5v5h7v6h-7Z"})}),u=(0,s.jsx)(r.SVG,{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24",children:(0,s.jsx)(r.Path,{d:"M4 15h11V9H4v6zM18.5 4v16H20V4h-1.5z"})}),m=window.wp.element,p=[["core/group",{style:{spacing:{padding:{top:"50px",bottom:"50px",left:"16px",right:"16px"}}},layout:{type:"constrained",contentSize:"600px"}},[["core/heading",{textAlign:"center",placeholder:(0,a.__)("Looking for Best  Theme for your Agency?","cozy-addons")},[]],["core/paragraph",{align:"center",placeholder:(0,a.__)("Meet the Blockpage  - The Ultimate Multipurpose block base FSE WordPress theme with 120+ pre-build ready to use patterns library with homepage and inner page layout with one click demo import","cozy-addons")},[]],["core/buttons",{layout:{type:"flex",justifyContent:"center"}},[["core/button",{style:{color:{gradient:"linear-gradient(135deg,rgb(8,183,134) 0%,rgb(35,26,132) 100%)"},border:{radius:"60px"}},placeholder:(0,a.__)("Download Now","cozy-addons")}],["core/button",{style:{color:{background:"#dcf2ec",text:"#0ba986"},border:{radius:"60px"}},placeholder:(0,a.__)("Explore Demos","cozy-addons")}]]]]]],g=(0,m.memo)((({attributes:e})=>{const t=(0,c.useInnerBlocksProps)({className:`cozy-modal-${e.modalType} event-${e.modalEvent}`},{template:p,renderAppender:!1,orientation:"horizontal"});return(0,n.createElement)("div",{...t})})),h=(0,m.memo)((({clientId:e,attributes:t})=>{const o=`cozyBlock_${e.replace(/-/gi,"_")}`,l=`\n    .cozy-block-wrapper[data-block="${e}"] {\n\t\ttext-align: ${t.clickButtonStyles?.justify?t.clickButtonStyles?.justify:""};\n\t}\n\n    .cozy-modal-open[data-type="${e}"] {\n      padding: ${t.clickButtonStyles.padding.top}px ${t.clickButtonStyles.padding.right}px ${t.clickButtonStyles.padding.bottom}px ${t.clickButtonStyles.padding.left}px;\n      border-style: ${t.clickButtonStyles.borderType};\n      border-width: ${t.clickButtonStyles.borderWidth.top}px ${t.clickButtonStyles.borderWidth.right}px ${t.clickButtonStyles.borderWidth.bottom}px ${t.clickButtonStyles.borderWidth.left}px; \n      border-color: ${t.clickButtonStyles.borderColor};\n      border-radius: ${t.clickButtonStyles.borderRadius}px;\n      font-size: ${t.clickButtonStyles.fontSize}px;\n      color: ${t.clickButtonStyles.color};\n      background-color: ${t.clickButtonStyles.bgColor};\n    }\n    .cozy-modal-open[data-type="${e}"] .cozy-modal-open__img {\n\t\twidth: ${t.clickButtonStyles?.imgWidth?`${t.clickButtonStyles?.imgWidth}px`:"100px"};\n\t\theight: ${t.clickButtonStyles?.imgHeight?`${t.clickButtonStyles?.imgHeight}px`:"100px"};\n\t\tborder-radius: ${t.clickButtonStyles?.imgRadius?`${t.clickButtonStyles?.imgRadius}px`:""};\n\t}\n    .cozy-modal-open[data-type="${e}"] .cozy-modal-open__img img {\n\t\tborder-radius: ${t.clickButtonStyles?.imgRadius?`${t.clickButtonStyles?.imgRadius}px`:""};\n\t}\n    .cozy-modal-open[data-type="${e}"]:hover {\n      color: ${t.clickButtonStyles.colorHover};\n      background-color: ${t.clickButtonStyles.bgColorHover};\n    }\n\n    #${o} {\n      padding: ${t.padding.top}px ${t.padding.right}px ${t.padding.bottom}px ${t.padding.left}px;\n      background-color: ${t.backgroundColor};\n    }\n    #${o}.type-default {\n      width: ${t.boxWidth}px;\n    }\n    #${o} .modal-icon-wrapper {\n\t\tdisplay: ${t.iconStyles?.enabled?"flex":"none"};\n\t\twidth: ${t.iconStyles?.boxWidth?`${t.iconStyles?.boxWidth}px`:"36px"};\n\t\theight: ${t.iconStyles?.boxHeight?`${t.iconStyles?.boxHeight}px`:"36px"};\n\t\tborder-radius: ${t.iconStyles?.radius?`${t.iconStyles?.radius}px`:"100px"};\n\t\tbackground-color: ${t.iconStyles?.bg?`${t.iconStyles?.bg}`:""};\n\t}\n    #${o} .modal-icon-wrapper:hover {\n\t\tbackground-color: ${t.iconStyles?.bgHover?`${t.iconStyles?.bgHover}`:""};\n\t}\n    #${o} .modal-icon-wrapper svg {\n      width: ${t.iconStyles.iconSize}px;\n      height: ${t.iconStyles.iconSize}px;\n      fill: ${t.iconStyles.iconColor};\n    }\n    #${o} .modal-icon-wrapper:hover svg {\n      fill: ${t.iconStyles.iconColorHover};\n    }\n  `;return(0,n.createElement)(n.Fragment,null,(0,n.createElement)("style",{dangerouslySetInnerHTML:{__html:l}}),"default"===t.modalType&&"click"===t.modalEvent&&(0,n.createElement)("a",{className:"cozy-modal-open","data-type":e},("default"===t.clickButtonStyles?.content||!t.clickButtonStyles?.content)&&(0,a.__)(t.clickButtonStyles.label,"cozy-addons"),"image"===t.clickButtonStyles?.content&&t.clickButtonStyles?.imgURL&&(0,n.createElement)("figure",{className:"cozy-modal-open__img"+(t.clickButtonStyles?.imgHasPulse?" has-pulse-animation":"")},(0,n.createElement)("img",{src:t.clickButtonStyles?.imgURL}))),(0,n.createElement)("div",{className:`cozy-block-modal type-${t.modalType} event-${t.modalEvent} icon-align-${t.iconStyles.alignment}`,id:o},(0,n.createElement)("div",{className:"close-icon-wrapper"},(0,n.createElement)("div",{className:"modal-icon-wrapper"},(0,n.createElement)("svg",{className:"modal-close-icon",width:"16",height:"16",viewBox:"0 0 18 18",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"M11.8516 8.59375L16.7378 3.70752C17.3374 3.10791 17.3374 2.13574 16.7378 1.53564L15.6519 0.449707C15.0522 -0.149902 14.0801 -0.149902 13.48 0.449707L8.59375 5.33594L3.70752 0.449707C3.10791 -0.149902 2.13574 -0.149902 1.53564 0.449707L0.449707 1.53564C-0.149902 2.13525 -0.149902 3.10742 0.449707 3.70752L5.33594 8.59375L0.449707 13.48C-0.149902 14.0796 -0.149902 15.0518 0.449707 15.6519L1.53564 16.7378C2.13525 17.3374 3.10791 17.3374 3.70752 16.7378L8.59375 11.8516L13.48 16.7378C14.0796 17.3374 15.0522 17.3374 15.6519 16.7378L16.7378 15.6519C17.3374 15.0522 17.3374 14.0801 16.7378 13.48L11.8516 8.59375Z"})))),(0,n.createElement)(g,{attributes:t})))})),b=JSON.parse('{"UU":"cozy-block/modal","h_":"Capture attention with our \'Popup Builder\' block, a pop-up window designed to showcase offers and promotions, providing a compelling way to communicate with your audience."}'),S=(0,n.createElement)("svg",{width:"28",height:"21",viewBox:"0 0 28 21",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("rect",{fill:"none",x:"1",y:"3",width:"25",height:"17",stroke:"#0C50FF","stroke-width":"2"}),(0,n.createElement)("path",{d:"M5 8H7.75H10.5",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("path",{d:"M6 10H9.5H13.5",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("path",{d:"M8 12L13.1333 12L19 12",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("path",{d:"M14 10H17.5L21 10",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("path",{d:"M11 8H16.5",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("path",{d:"M17 8H22",stroke:"#0C50FF","stroke-opacity":"0.5"}),(0,n.createElement)("rect",{x:"10",y:"15",width:"7",height:"2",fill:"#0C50FF"}),(0,n.createElement)("rect",{x:"21",width:"7",height:"7",rx:"3.5",fill:"#80A2FA"}),(0,n.createElement)("path",{d:"M25.0686 3.5L25.9215 2.64713C26.0262 2.54247 26.0262 2.37278 25.9215 2.26804L25.732 2.07849C25.6273 1.97384 25.4576 1.97384 25.3529 2.07849L24.5 2.93136L23.6471 2.07849C23.5425 1.97384 23.3728 1.97384 23.268 2.07849L23.0785 2.26804C22.9738 2.3727 22.9738 2.54239 23.0785 2.64713L23.9314 3.5L23.0785 4.35287C22.9738 4.45753 22.9738 4.62722 23.0785 4.73196L23.268 4.92151C23.3727 5.02616 23.5425 5.02616 23.6471 4.92151L24.5 4.06864L25.3529 4.92151C25.4575 5.02616 25.6273 5.02616 25.732 4.92151L25.9215 4.73196C26.0262 4.6273 26.0262 4.45761 25.9215 4.35287L25.0686 3.5Z",fill:"white"}));(0,l.registerBlockType)(b.UU,{title:(0,a.__)("Popup Builder","cozy-addons"),description:(0,a.__)(b.h_,"cozy-addons"),icon:{src:S},example:{attributes:{cover:cozyBlockAssets.imageDir+"/preview_popup.jpg"},viewportWidth:1200},edit:function(e){const{attributes:t,setAttributes:o,clientId:l}=e;if(t.cover)return(0,n.createElement)("img",{src:t.cover});t.blockClientId=l;const r=(0,c.useBlockProps)({className:"cozy-block-wrapper"}),[s,p]=(0,m.useState)(!0),[g,b]=(0,m.useState)(!0),[S,_]=(0,m.useState)(!0),k=(e,l)=>{let n={...t.padding};n={...n,top:Math.abs(l),right:Math.abs(l),bottom:Math.abs(l),left:Math.abs(l)},o(s?{...t,padding:n}:{...t,padding:{...t.padding,[e]:Math.abs(l)}})},C=(e,l)=>{let n={...t.clickButtonStyles.padding};n={...n,top:Math.abs(l),right:Math.abs(l),bottom:Math.abs(l),left:Math.abs(l)},o(g?{...t,clickButtonStyles:{...t.clickButtonStyles,padding:n}}:{...t,clickButtonStyles:{...t.clickButtonStyles,padding:{...t.clickButtonStyles.padding,[e]:Math.abs(l)}}})},v=(e,l)=>{let n={...t.clickButtonStyles.borderWidth};n={...n,top:Math.abs(l),right:Math.abs(l),bottom:Math.abs(l),left:Math.abs(l)},o(S?{...t,clickButtonStyles:{...t.clickButtonStyles,borderWidth:n}}:{...t,clickButtonStyles:{...t.clickButtonStyles,borderWidth:{...t.clickButtonStyles.borderWidth,[e]:Math.abs(l)}}})};function B(e){o({...t,clickButtonStyles:{...t.clickButtonStyles,imgURL:e.url}})}return(0,n.createElement)(n.Fragment,null,(0,n.createElement)("div",{...r},(0,n.createElement)(h,{clientId:l,attributes:t})),(0,n.createElement)(c.InspectorControls,{key:"setting",group:"settings"},(0,n.createElement)(i.PanelBody,{title:(0,a.__)("Popup","cozy-addons")},(0,n.createElement)(i.SelectControl,{label:(0,a.__)("Type","cozy-addons"),options:[{label:(0,a.__)("Default"),value:"default"},{label:(0,a.__)("Notifier"),value:"notifier"}],value:t.modalType,onChange:e=>o({...t,modalType:e})}),"default"===t.modalType&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Box Width","cozy-addons"),min:100,step:5,max:1500,value:t.boxWidth,onChange:e=>o({...t,boxWidth:e})}),(0,n.createElement)(i.SelectControl,{label:(0,a.__)("Event","cozy-addons"),options:[{label:(0,a.__)("On Load"),value:"load"},{label:(0,a.__)("On Click"),value:"click"}],value:t.modalEvent,onChange:e=>{o({...t,modalEvent:e})}}),"load"===t.modalEvent&&(0,n.createElement)(i.ToggleControl,{label:(0,a.__)("Load on Every Refresh","cozy-addons"),checked:t.loadOnRefresh,onChange:e=>o({...t,loadOnRefresh:e})}),"click"===t.modalEvent&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(i.__experimentalToggleGroupControl,{label:(0,a.__)("Button Content","cozy-addons"),isBlock:!0,value:t.clickButtonStyles?.content?t.clickButtonStyles?.content:"default",onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,content:e}})},(0,n.createElement)(i.__experimentalToggleGroupControlOption,{label:(0,a.__)("Default","cozy-addons"),value:"default"}),(0,n.createElement)(i.__experimentalToggleGroupControlOption,{label:(0,a.__)("Image","cozy-addons"),value:"image"})),("default"===t.clickButtonStyles?.content||!t.clickButtonStyles?.content)&&(0,n.createElement)(i.TextControl,{label:(0,a.__)("Button Label","cozy-addons"),type:"text",value:t.clickButtonStyles.label,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,label:e}})}),"image"===t.clickButtonStyles?.content&&(0,n.createElement)(n.Fragment,null,!t.clickButtonStyles?.imgURL&&(0,n.createElement)(c.MediaUploadCheck,null,(0,n.createElement)(c.MediaUpload,{onSelect:e=>B(e),allowedTypes:["image"],mode:"browse",render:({open:e})=>(0,n.createElement)("div",{className:"components-base-control",onClick:e},(0,n.createElement)("button",{type:"button",className:"components-button is-secondary"},(0,a.__)("Choose from Media Library","cozy-addons")))})),t.clickButtonStyles?.imgURL&&(0,n.createElement)(c.MediaUploadCheck,null,(0,n.createElement)(c.MediaUpload,{onSelect:e=>B(e),allowedTypes:["image"],mode:"browse",render:({open:e})=>(0,n.createElement)("div",{className:"components-base-control",onClick:e,style:{margin:"0 auto",textAlign:"center"}},(0,n.createElement)("img",{src:t.clickButtonStyles?.imgURL,width:100,height:100}),(0,n.createElement)("p",{style:{color:"#cf2e2e",textDecoration:"underline",cursor:"pointer"}},(0,a.__)("Replace Image","cozy-addons")))}))),(0,n.createElement)(i.__experimentalToggleGroupControl,{label:(0,a.__)("Button Justification","cozy-addons"),value:t.clickButtonStyles?.justify,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,justify:e}})},(0,n.createElement)(i.__experimentalToggleGroupControlOptionIcon,{label:(0,a.__)("Left","cozy-addons"),value:"left",icon:d}),(0,n.createElement)(i.__experimentalToggleGroupControlOptionIcon,{label:(0,a.__)("Center","cozy-addons"),value:"center",icon:y}),(0,n.createElement)(i.__experimentalToggleGroupControlOptionIcon,{label:(0,a.__)("Right","cozy-addons"),value:"right",icon:u})))),(0,n.createElement)(i.ToggleControl,{label:(0,a.__)("Close Icon","cozy-addons"),checked:t.iconStyles?.enabled,onChange:e=>o({...t,iconStyles:{...t.iconStyles,enabled:e}})})),(0,n.createElement)(i.PanelBody,{title:(0,a.__)("Close Icon","cozy-addons")},(0,n.createElement)(i.SelectControl,{label:(0,a.__)("Alignment","cozy-addons"),options:[{label:(0,a.__)("Left","cozy-addons"),value:"left"},{label:(0,a.__)("Right","cozy-addons"),value:"right"}],value:t.iconStyles.alignment,onChange:e=>o({...t,iconStyles:{...t.iconStyles,alignment:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Vertical Spacing","cozy-addons"),min:-300,max:300,step:1,value:t.iconStyles.verticalSpacing,onChange:e=>o({...t,iconStyles:{...t.iconStyles,verticalSpacing:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Horizontal Spacing","cozy-addons"),min:-300,max:300,step:1,value:t.iconStyles.horizontalSpacing,onChange:e=>o({...t,iconStyles:{...t.iconStyles,horizontalSpacing:e}})}))),(0,n.createElement)(c.InspectorControls,{key:"style",group:"styles"},(0,n.createElement)(i.PanelBody,{title:(0,a.__)("Container Styles","cozy-addons")},(0,n.createElement)(i.BaseControl,null,(0,n.createElement)(i.BaseControl.VisualLabel,null,(0,a.__)("Padding","cozy-addons")),(0,n.createElement)("div",{style:{display:"flex",gap:"5px",height:"50px",position:"relative"}},(0,n.createElement)("button",{className:"cozy-link-styles "+(s?"":"cozy-attr-link-disabled"),onClick:()=>p(!s)},(0,n.createElement)("svg",{width:"10",height:"16",viewBox:"0 0 15 28",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"M6.18931 9.59516L6.18931 19.3466H8.70581V9.59516H6.18931Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 7.88029L0.0553284 13.2126H2.53381L2.53381 7.88029C2.82201 4.53678 5.6079 3.53757 6.94321 3.4415C10.9203 3.15534 12.1019 6.00678 12.3901 7.88029V13.2126L14.8398 13.2126V7.88029C14.1251 1.90809 9.2776 0.780139 6.94321 0.962687C1.84791 1.30857 0.0553284 5.92031 0.0553284 7.88029Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 20.9042L0.0553284 15.5718H2.53381L2.53381 20.9042C2.82201 24.2477 5.6079 25.2469 6.94321 25.343C10.9203 25.6291 12.1019 22.7777 12.3901 20.9042V15.5718L14.8398 15.5718V20.9042C14.1251 26.8764 9.2776 28.0043 6.94321 27.8218C1.84791 27.4759 0.0553284 22.8641 0.0553284 20.9042Z",fill:"black"}))),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Top","cozy-addons"),value:t.padding.top,onChange:e=>k("top",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Right","cozy-addons"),value:t.padding.right,onChange:e=>k("right",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Bottom","cozy-addons"),value:t.padding.bottom,onChange:e=>k("bottom",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Left","cozy-addons"),value:t.padding.left,onChange:e=>k("left",e)}))),(0,n.createElement)(c.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,a.__)("Color","cozy-addons"),colorSettings:[{value:t.backgroundColor,onChange:e=>o({...t,backgroundColor:e}),label:(0,a.__)("Background","cozy-addons")},{value:t.backgroundOverlayColor,onChange:e=>o({...t,backgroundOverlayColor:e}),label:(0,a.__)("Overlay","cozy-addons")}]})),(0,n.createElement)(i.PanelBody,{title:(0,a.__)("Icon Styles","cozy-addons"),initialOpen:!1},(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Box Width","cozy-addons"),min:10,max:100,step:1,defaultValue:36,value:t.iconStyles?.boxWidth,onChange:e=>o({...t,iconStyles:{...t.iconStyles,boxWidth:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Box Height","cozy-addons"),min:10,max:100,step:1,defaultValue:36,value:t.iconStyles?.boxHeight,onChange:e=>o({...t,iconStyles:{...t.iconStyles,boxHeight:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Size","cozy-addons"),min:0,max:50,step:1,value:t.iconStyles.iconSize,onChange:e=>o({...t,iconStyles:{...t.iconStyles,iconSize:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Border Radius","cozy-addons"),min:0,max:100,step:1,value:t.iconStyles?.radius,onChange:e=>o({...t,iconStyles:{...t.iconStyles,radius:e}})}),(0,n.createElement)(c.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,a.__)("Color","cozy-addons"),colorSettings:[{label:(0,a.__)("Icon (Default)","cozy-addons"),value:t.iconStyles.iconColor,onChange:e=>o({...t,iconStyles:{...t.iconStyles,iconColor:e}})},{label:(0,a.__)("Icon (Hover)","cozy-addons"),value:t.iconStyles.iconColorHover,onChange:e=>o({...t,iconStyles:{...t.iconStyles,iconColorHover:e}})},{label:(0,a.__)("Background (Default)","cozy-addons"),value:t.iconStyles?.bg,onChange:e=>o({...t,iconStyles:{...t.iconStyles,bg:e}})},{label:(0,a.__)("Background (Hover)","cozy-addons"),value:t.iconStyles?.bgHover,onChange:e=>o({...t,iconStyles:{...t.iconStyles,bgHover:e}})}]})),"default"===t.modalType&&"click"===t.modalEvent&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(i.PanelBody,{title:(0,a.__)("Button Styles","cozy-addons"),initialOpen:!1},(0,n.createElement)(i.BaseControl,null,(0,n.createElement)(i.BaseControl.VisualLabel,null,(0,a.__)("Padding","cozy-addons")),(0,n.createElement)("div",{style:{display:"flex",gap:"5px",height:"50px",position:"relative"}},(0,n.createElement)("button",{className:"cozy-link-styles "+(g?"":"cozy-attr-link-disabled"),onClick:()=>b(!g)},(0,n.createElement)("svg",{width:"10",height:"16",viewBox:"0 0 15 28",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"M6.18931 9.59516L6.18931 19.3466H8.70581V9.59516H6.18931Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 7.88029L0.0553284 13.2126H2.53381L2.53381 7.88029C2.82201 4.53678 5.6079 3.53757 6.94321 3.4415C10.9203 3.15534 12.1019 6.00678 12.3901 7.88029V13.2126L14.8398 13.2126V7.88029C14.1251 1.90809 9.2776 0.780139 6.94321 0.962687C1.84791 1.30857 0.0553284 5.92031 0.0553284 7.88029Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 20.9042L0.0553284 15.5718H2.53381L2.53381 20.9042C2.82201 24.2477 5.6079 25.2469 6.94321 25.343C10.9203 25.6291 12.1019 22.7777 12.3901 20.9042V15.5718L14.8398 15.5718V20.9042C14.1251 26.8764 9.2776 28.0043 6.94321 27.8218C1.84791 27.4759 0.0553284 22.8641 0.0553284 20.9042Z",fill:"black"}))),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Top","cozy-addons"),value:t.clickButtonStyles.padding.top,onChange:e=>C("top",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Right","cozy-addons"),value:t.clickButtonStyles.padding.right,onChange:e=>C("right",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,label:(0,a.__)("Bottom","cozy-addons"),value:t.clickButtonStyles.padding.bottom,onChange:e=>C("bottom",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,value:t.clickButtonStyles.padding.left,label:(0,a.__)("Left","cozy-addons"),onChange:e=>C("left",e)}))),(0,n.createElement)(i.SelectControl,{label:(0,a.__)("Border Type","cozy-addons"),value:t.clickButtonStyles.borderType,options:[{label:(0,a.__)("None","cozy-addons"),value:"none"},{label:(0,a.__)("Solid","cozy-addons"),value:"solid"},{label:(0,a.__)("Double","cozy-addons"),value:"double"},{label:(0,a.__)("Dotted","cozy-addons"),value:"dotted"},{label:(0,a.__)("Dashed","cozy-addons"),value:"dashed"},{label:(0,a.__)("Groove","cozy-addons"),value:"groove"}],onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,borderType:e}})}),"none"!==t.clickButtonStyles.borderType&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(i.BaseControl,null,(0,n.createElement)(i.BaseControl.VisualLabel,null,(0,a.__)("Border Width","cozy-addons")),(0,n.createElement)("div",{style:{display:"flex",gap:"5px",height:"50px",position:"relative"}},(0,n.createElement)("button",{className:"cozy-link-styles "+(S?"":"cozy-attr-link-disabled"),onClick:()=>_(!S)},(0,n.createElement)("svg",{width:"10",height:"16",viewBox:"0 0 15 28",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"M6.18931 9.59516L6.18931 19.3466H8.70581V9.59516H6.18931Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 7.88029L0.0553284 13.2126H2.53381L2.53381 7.88029C2.82201 4.53678 5.6079 3.53757 6.94321 3.4415C10.9203 3.15534 12.1019 6.00678 12.3901 7.88029V13.2126L14.8398 13.2126V7.88029C14.1251 1.90809 9.2776 0.780139 6.94321 0.962687C1.84791 1.30857 0.0553284 5.92031 0.0553284 7.88029Z",fill:"black"}),(0,n.createElement)("path",{d:"M0.0553284 20.9042L0.0553284 15.5718H2.53381L2.53381 20.9042C2.82201 24.2477 5.6079 25.2469 6.94321 25.343C10.9203 25.6291 12.1019 22.7777 12.3901 20.9042V15.5718L14.8398 15.5718V20.9042C14.1251 26.8764 9.2776 28.0043 6.94321 27.8218C1.84791 27.4759 0.0553284 22.8641 0.0553284 20.9042Z",fill:"black"}))),(0,n.createElement)(i.TextControl,{type:"number",step:1,min:0,label:(0,a.__)("Top","cozy-addons"),value:t.clickButtonStyles.borderWidth.top,onChange:e=>v("top",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,min:0,label:(0,a.__)("Right","cozy-addons"),value:t.clickButtonStyles.borderWidth.right,onChange:e=>v("right",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,min:0,label:(0,a.__)("Bottom","cozy-addons"),value:t.clickButtonStyles.borderWidth.bottom,onChange:e=>v("bottom",e)}),(0,n.createElement)(i.TextControl,{type:"number",step:1,min:0,label:(0,a.__)("Left","cozy-addons"),value:t.clickButtonStyles.borderWidth.left,onChange:e=>v("left",e)}))),(0,n.createElement)(c.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,a.__)("Color","cozy-addons"),colorSettings:[{value:t.clickButtonStyles.borderColor,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,borderColor:e}}),label:(0,a.__)("Border","cozy-addons")}]})),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Border Radius","cozy-addons"),min:0,max:50,step:1,value:t.clickButtonStyles.borderRadius,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,borderRadius:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Font Size","cozy-addons"),min:0,max:50,step:1,value:t.clickButtonStyles.fontSize,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,fontSize:e}})}),"image"===t.clickButtonStyles?.content&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Image Width","cozy-addons"),min:0,max:300,step:1,value:t.clickButtonStyles?.imgWidth,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,imgWidth:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Image Height","cozy-addons"),min:0,max:300,step:1,value:t.clickButtonStyles?.imgHeight,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,imgHeight:e}})}),(0,n.createElement)(i.RangeControl,{label:(0,a.__)("Image Radius","cozy-addons"),min:0,max:100,step:1,value:t.clickButtonStyles?.imgRadius,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,imgRadius:e}})}),(0,n.createElement)(i.ToggleControl,{label:(0,a.__)("Pulse Effect","cozy-addons"),checked:t.clickButtonStyles?.imgHasPulse,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,imgHasPulse:e}})})),(0,n.createElement)(c.PanelColorSettings,{className:"cozy-color-control",enableAlpha:!0,title:(0,a.__)("Color","cozy-addons"),colorSettings:[{value:t.clickButtonStyles.color,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,color:e}}),label:(0,a.__)("Text (Default)","cozy-addons")},{value:t.clickButtonStyles.colorHover,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,colorHover:e}}),label:(0,a.__)("Text (Hover)","cozy-addons")},{value:t.clickButtonStyles.bgColor,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,bgColor:e}}),label:(0,a.__)("Background (Default)","cozy-addons")},{value:t.clickButtonStyles.bgColorHover,onChange:e=>o({...t,clickButtonStyles:{...t.clickButtonStyles,bgColorHover:e}}),label:(0,a.__)("Background (Hover)","cozy-addons")}]})))))},save:function(e){const{attributes:t}=e,o=`cozyBlock_${(l=t.blockClientId,l.replace(/[;=()\s]/g,"")).replace(/-/gi,"_")}`;var l;return(0,n.createElement)(n.Fragment,null,"default"===t.modalType&&"click"===t.modalEvent&&(0,n.createElement)("a",{className:"cozy-modal-open","data-type":t.blockClientId},("default"===t.clickButtonStyles?.content||!t.clickButtonStyles?.content)&&(0,a.__)(t.clickButtonStyles.label,"cozy-addons"),"image"===t.clickButtonStyles?.content&&t.clickButtonStyles?.imgURL&&(0,n.createElement)("figure",{className:"cozy-modal-open__img"+(t.clickButtonStyles?.imgHasPulse?" has-pulse-animation":"")},(0,n.createElement)("img",{src:t.clickButtonStyles?.imgURL}))),(0,n.createElement)("div",{className:`cozy-block-modal  type-${t.modalType} ${"default"===t.modalType?"event-"+t.modalEvent:""} ${"default"===t.modalType?"display-none":""} icon-align-${t.iconStyles.alignment}`,id:o},(0,n.createElement)("div",{className:"close-icon-wrapper"},(0,n.createElement)("div",{className:"modal-icon-wrapper"},(0,n.createElement)("svg",{className:"modal-close-icon",width:"16",height:"16",viewBox:"0 0 18 18",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)("path",{d:"M11.8516 8.59375L16.7378 3.70752C17.3374 3.10791 17.3374 2.13574 16.7378 1.53564L15.6519 0.449707C15.0522 -0.149902 14.0801 -0.149902 13.48 0.449707L8.59375 5.33594L3.70752 0.449707C3.10791 -0.149902 2.13574 -0.149902 1.53564 0.449707L0.449707 1.53564C-0.149902 2.13525 -0.149902 3.10742 0.449707 3.70752L5.33594 8.59375L0.449707 13.48C-0.149902 14.0796 -0.149902 15.0518 0.449707 15.6519L1.53564 16.7378C2.13525 17.3374 3.10791 17.3374 3.70752 16.7378L8.59375 11.8516L13.48 16.7378C14.0796 17.3374 15.0522 17.3374 15.6519 16.7378L16.7378 15.6519C17.3374 15.0522 17.3374 14.0801 16.7378 13.48L11.8516 8.59375Z"})))),(0,n.createElement)(c.InnerBlocks.Content,null)))}})},20:(e,t,o)=>{var l=o(609),n=Symbol.for("react.element"),a=(Symbol.for("react.fragment"),Object.prototype.hasOwnProperty),c=l.__SECRET_INTERNALS_DO_NOT_USE_OR_YOU_WILL_BE_FIRED.ReactCurrentOwner,i={key:!0,ref:!0,__self:!0,__source:!0};t.jsx=function(e,t,o){var l,r={},s=null,d=null;for(l in void 0!==o&&(s=""+o),void 0!==t.key&&(s=""+t.key),void 0!==t.ref&&(d=t.ref),t)a.call(t,l)&&!i.hasOwnProperty(l)&&(r[l]=t[l]);if(e&&e.defaultProps)for(l in t=e.defaultProps)void 0===r[l]&&(r[l]=t[l]);return{$$typeof:n,type:e,key:s,ref:d,props:r,_owner:c.current}}},848:(e,t,o)=>{e.exports=o(20)},609:e=>{e.exports=window.React}},o={};function l(e){var n=o[e];if(void 0!==n)return n.exports;var a=o[e]={exports:{}};return t[e](a,a.exports,l),a.exports}l.m=t,e=[],l.O=(t,o,n,a)=>{if(!o){var c=1/0;for(d=0;d<e.length;d++){for(var[o,n,a]=e[d],i=!0,r=0;r<o.length;r++)(!1&a||c>=a)&&Object.keys(l.O).every((e=>l.O[e](o[r])))?o.splice(r--,1):(i=!1,a<c&&(c=a));if(i){e.splice(d--,1);var s=n();void 0!==s&&(t=s)}}return t}a=a||0;for(var d=e.length;d>0&&e[d-1][2]>a;d--)e[d]=e[d-1];e[d]=[o,n,a]},l.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={57:0,350:0};l.O.j=t=>0===e[t];var t=(t,o)=>{var n,a,[c,i,r]=o,s=0;if(c.some((t=>0!==e[t]))){for(n in i)l.o(i,n)&&(l.m[n]=i[n]);if(r)var d=r(l)}for(t&&t(o);s<c.length;s++)a=c[s],l.o(e,a)&&e[a]&&e[a][0](),e[a]=0;return l.O(d)},o=globalThis.webpackChunkmodal=globalThis.webpackChunkmodal||[];o.forEach(t.bind(null,0)),o.push=t.bind(null,o.push.bind(o))})();var n=l.O(void 0,[350],(()=>l(450)));n=l.O(n)})();