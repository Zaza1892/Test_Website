TrackingConsentManager=(function(){var consentCookieName="sf-tracking-consent";
var consentDialogHtml="";
var consentDialog=null;
var eventListeners={AfterDialogDisplayed:[],BeforeDialogClosed:[],ConsentChanged:[],};
function closeConsentDialog(){if(consentDialog==null){return;
}invokeEventListeners("BeforeDialogClosed",[consentDialog]);
document.body.removeChild(consentDialog);
consentDialog=null;
}function openConsentDialog(){if(!document.body){return;
}closeConsentDialog();
consentDialog=document.createElement("div");
var dialogHtml=document.getElementById("sf-tracking-consent-manager");
if(dialogHtml){consentDialogHtml=dialogHtml.textContent;
consentDialog.innerHTML=consentDialogHtml;
document.body.insertBefore(consentDialog,document.body.childNodes[0]);
}var scripts=consentDialog.getElementsByTagName("script");
for(var idx=0;
idx<scripts.length;
idx++){try{eval(scripts[idx].textContent);
}catch(err){console.error(err);
}}invokeEventListeners("AfterDialogDisplayed",[consentDialog]);
}function openDialogIfConsentNotProvided(){var userConsent=readCookie(consentCookieName);
if(userConsent!=null){return;
}openConsentDialog();
}function createCookie(name,value,days){if(days){var date=new Date();
date.setTime(date.getTime()+(days*24*60*60*1000));
var expires="; expires="+date.toGMTString();
}else{var expires="";
}document.cookie=name+"="+value+expires+"; path=/";
}function readCookie(name){var nameEQ=name+"=";
var ca=document.cookie.split(";");
for(var i=0;
i<ca.length;
i++){var c=ca[i];
while(c.charAt(0)==" "){c=c.substring(1,c.length);
}if(c.indexOf(nameEQ)==0){return c.substring(nameEQ.length,c.length);
}}return null;
}function findChildById(root,id){if(!root){return null;
}if(!root.childNodes){return null;
}for(var index=0;
index<root.childNodes.length;
index++){var child=root.childNodes[index];
if(child.id==id){return child;
}var subChild=findChildById(child,id);
if(subChild!=null){return subChild;
}}return null;
}function invokeEventListeners(eventName,args){var collection=eventListeners[eventName];
if(!collection){return;
}for(var index=0;
index<collection.length;
index++){try{collection[index].apply(this,args);
}catch(err){console.error("TrackingConsentManager: Event listener of "+eventName+" event thew error: "+err);
}}}if(window.addEventListener){window.addEventListener("DOMContentLoaded",openDialogIfConsentNotProvided,false);
}else{if(window.attachEvent){window.attachEvent("onload",openDialogIfConsentNotProvided);
}}return{canTrackCurrentUser:function(){return readCookie(consentCookieName)=="true";
},askForUserConsent:function(){openConsentDialog();
},updateUserConsent:function(consent){var accepted=Boolean(consent);
var oldState=this.canTrackCurrentUser();
createCookie(consentCookieName,accepted,9999);
if(accepted!=oldState){invokeEventListeners("ConsentChanged",[accepted]);
}closeConsentDialog();
},addEventListener:function(eventName,listener){if(typeof listener!="function"){return;
}var collection=eventListeners[eventName];
if(!collection){return;
}collection.push(listener);
},removeEventListener:function(eventName,listener){if(typeof listener!="function"){return;
}var collection=eventListeners[eventName];
if(!collection){return;
}var index=collection.indexOf(listener);
if(index<0){return;
}collection.splice(index,1);
}};
})();
