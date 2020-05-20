
var WA={version:'2.00.05',running:false};WA.Function={};WA.Function.buildTransformer=function(prefct,postfct,scope)
{var self=this;if(!WA.isFunction(prefct)&&!WA.isFunction(postfct))
return this;return function()
{var args=WA.isFunction(prefct)?prefct.apply(scope||self,arguments):arguments;var ret=self.apply(scope||self,args);return WA.isFunction(postfct)?postfct.apply(scope||self,[ret]):ret;}}
WA.Function.buildFilter=function(fct,scope)
{var self=this;if(!WA.isFunction(fct))
return this;return function()
{return(fct.apply(scope||self,arguments)==true)?self.apply(scope||self,arguments):undefined;}}
WA.Function.buildCompact=function()
{var self=this;var args=arguments;return function()
{var r1=Array.prototype.slice.call(args);var r2=Array.prototype.slice.call(arguments);return self.apply(self,r1.concat(r2));}}
WA.Function.delay=function(delay)
{var self=this;var args=[];for(var i=1,l=arguments.length;i<l;args.push(arguments[i++]));var t=setTimeout(function(){return self.apply(self,args);},delay);return t;}
WA.String={};WA.String.sprintf=function()
{if(WA.isObject(arguments[0]))
{var args=arguments[0];return this.replace(/\{([A-Za-z0-9\-_\.]+)\}/g,function(p0,p1){return args[p1];});}
else
{var args=arguments;return this.replace(/\{(\d+)\}/g,function(p0,p1){return args[p1];});}}
WA.String.escape=function(value)
{var newstr=(value!=undefined&&value!=null)?value:this;return newstr.replace(/("|'|\\)/g,"\\$1");}
WA.String.padding=function(size,pad,value)
{if(!pad)pad=' ';var newstr=new String((value!=undefined&&value!=null)?value:this);while(newstr.length<size)
{newstr=pad+newstr;}
return newstr;}
WA.String.trim=function(value)
{var newstr=(value!=undefined&&value!=null)?value:this;return newstr.replace(/^(\s|&nbsp;)*|(\s|&nbsp;)*$/g,'');};WA.Array={};WA.Array.indexOf=function(val,field)
{for(var i=0,l=this.length;i<l;i++)
{if((field&&this[i][field]==val)||(!field&&this[i]==val))
return i;}
return false;}
WA.Array.remove=function(o,field)
{var index=this.indexOf(o,field);if(index!=-1)
{this.splice(index,1);}
return this;}
WA.Date={};WA.Date.setNames=function(days,shortdays,months,shortmonths)
{WA.Date.days=days;WA.Date.shortdays=shortdays;WA.Date.months=months;WA.Date.shortmonths=shortmonths;}
WA.Date.setNames(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],['January','February','March','April','May','June','July','August','September','October','November','December'],['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']);WA.Date.basicdays=[31,28,31,30,31,30,31,31,30,31,30,31];WA.Date.isDate=function(year,month,day)
{var numdays=WA.Date.basicdays[month-1];return day>0&&!!numdays&&(day<=numdays||day==29&&year%4==0&&(year%100!=0||year%400==0));}
WA.Date.isTime=function(hour,min,sec)
{return hour>=0&&hour<=23&&min>=0&&min<=59&&sec>=0&&sec<=59;}
WA.Date.isValid=function(year,month,day,hour,min,sec,ms)
{hour=hour||0;min=min||0;sec=sec||0;ms=ms||0;return WA.Date.isDate(year,month,day)&&WA.Date.isTime(hour,min,sec)&&ms>=0&&ms<=999;}
WA.Date.isLeapYear=function(d)
{var year=d.getFullYear();return(year%4==0&&(year%100!=0||year%400==0));}
WA.Date.getOrdinalSuffix=function()
{switch(this.getDate())
{case 1:case 21:case 31:return'st';case 2:case 22:return'nd';case 3:case 23:return'rd';default:return'th';}}
WA.Date.getMaxMonthDays=function(d)
{var numdays=WA.Date.basicdays[d.getMonth()];if(numdays==28&&WA.Date.isLeapYear(d))
{numdays++;}
return numdays;}
WA.Date.getDayOfYear=function()
{var day=this.getDate();for(var i=0;i<=this.getMonth()-1;i++)
day+=WA.Date.basicdays[i]+(i==1&&WA.Date.isLeapYear(this)?1:0);return day;}
WA.Date.getWeekOfYear=function()
{var ms1d=86400000;var ms7d=604800000;var DC3=Date.UTC(this.getFullYear(),this.getMonth(),this.getDate()+3)/ms1d;var AWN=Math.floor(DC3/7);var Wyr=(new Date(AWN*ms7d)).getUTCFullYear();return AWN-Math.floor(Date.UTC(Wyr,0,7)/ms7d)+1;}
WA.Date.getGMTOffset=function(colon)
{return(this.getTimezoneOffset()>0?'-':'+')
+String.padding(2,'0',Math.floor(Math.abs(this.getTimezoneOffset())/60))
+(colon?':':'')
+String.padding(2,'0',Math.abs(this.getTimezoneOffset()%60));}
WA.Date.getTimezone=function()
{return this.toString().replace(/^.* (?:\((.*)\)|([A-Z]{1,4})(?:[\-+][0-9]{4})?(?: -?\d+)?)$/,'$1$2').replace(/[^A-Z]/g,'');}
WA.Date.grabformats={j:"this.getDate()",d:"WA.String.padding(2, '0', this.getDate())",D:"WA.Date.shortdays[this.getDay()]",l:"WA.Date.days[this.getDay()]",w:"this.getDay()",N:"(this.getDay()==0?7:this.getDay())",S:"WA.Date.getOrdinalSuffix.call(this)",z:"WA.Date.getDayOfYear.call(this)",W:"WA.String.padding(2, '0', WA.Date.getWeekOfYear.call(this))",n:"(this.getMonth() + 1)",m:"WA.String.padding(2, '0', this.getMonth() + 1)",M:"WA.Date.shortmonths[this.getMonth()]",F:"WA.Date.months[this.getMonth()]",t:"WA.Date.getMaxMonthDays.call(this)",L:"(WA.Date.isLeapYear(this) ? 1 : 0)",o:"(this.getFullYear() + (WA.Date.getWeekOfYear.call(this) == 1 && this.getMonth() > 0 ? +1 : (WA.Date.getWeekOfYear.call(this) >= 52 && this.getMonth() < 11 ? -1 : 0)))",Y:"this.getFullYear()",y:"('' + this.getFullYear()).substring(2, 4)",a:"(this.getHours() < 12 ? 'am' : 'pm')",A:"(this.getHours() < 12 ? 'AM' : 'PM')",g:"((this.getHours() % 12) ? this.getHours() % 12 : 12)",G:"this.getHours()",h:"WA.String.padding(2, '0', (this.getHours() % 12) ? this.getHours() % 12 : 12)",H:"WA.String.padding(2, '0', this.getHours())",i:"WA.String.padding(2, '0', this.getMinutes())",s:"WA.String.padding(2, '0', this.getSeconds())",u:"WA.String.padding(3, '0', this.getMilliseconds())",O:"WA.String.getGMTOffset.call(this)",P:"WA.String.getGMTOffset.call(this, true)",T:"WA.String.getTimezone.call(this)",Z:"(this.getTimezoneOffset() * -60)",c:"this.getUTCFullYear() + '-' + WA.String.padding(2, '0', this.getUTCMonth() + 1) + '-' + WA.String.padding(2, '0', this.getUTCDate()) + 'T' + "
+"WA.String.padding(2, '0', this.getUTCHours()) + ':' + WA.String.padding(2, '0', this.getUTCMinutes()) + ':' + "
+"WA.String.padding(2, '0', this.getUTCSeconds()) + WA.Date.getGMTOffset.call(this, true)",U:"Math.round(this.getTime() / 1000)"};WA.Date.format=function(d,str)
{var code=[];for(var i=0,l=str.length;i<l;i++)
{var c=str.charAt(i);if(c=='\\')
{i++;code.push("'"+WA.String.escape(str.charAt(i))+"'");}
else
{WA.Date.grabformats[c]!=undefined?code.push(WA.Date.grabformats[c]):code.push("'"+WA.String.escape(c)+"'");}}
var f=new Function('return '+code.join('+')+';');return f.call(d);}
WA.zIndex=1;WA.getNextZIndex=function()
{return WA.zIndex++;}
WA.isDefined=function(val)
{return val!==undefined;}
WA.isEmpty=function(val,blank)
{return val===undefined||val===null||((WA.isArray(val)&&!val.length))||(!blank?val==='':false);}
WA.isBool=function(val)
{return typeof val==='boolean';}
WA.isNumber=function(val)
{return typeof val==='number'&&isFinite(val);}
WA.isString=function(val)
{return typeof val==='string'||Object.prototype.toString.apply(val)==='[object String]';}
WA.isArray=function(val)
{return Object.prototype.toString.apply(val)==='[object Array]';}
WA.isObject=function(val)
{return typeof val=='object';}
WA.isFunction=function(val)
{return Object.prototype.toString.apply(val)==='[object Function]';}
WA.isDate=function(val)
{return Object.prototype.toString.apply(val)==='[object Date]';}
WA.isDOM=function(o)
{return(o===window||(typeof Node==='object'?o instanceof Node:o!==null&&typeof o==='object'&&typeof o.nodeType==='number'&&typeof o.nodeName==='string'));}
WA.extend=function(collector,source)
{var f=function(){};f.prototype=source.prototype;collector.prototype=new f();collector.prototype.constructor=collector;collector.sourceconstructor=source;collector.source=source.prototype;return collector;}
WA.clone=function(obj)
{var cloned={};for(var i in obj)
{if(!obj.hasOwnProperty(i))
continue;if(typeof obj[i]=='object'&&!WA.isDOM(obj[i]))
cloned[i]=WA.clone(obj[i]);else
cloned[i]=obj[i];}
return cloned;}
WA.sizeof=function(obj,strict)
{var c=0;for(var i in obj)
if(!WA.isFunction(obj[i])&&((obj.hasOwnProperty(i)&&strict)||!strict))c++;return c;}
WA.createDomNode=function(type,id,classname)
{var domnode=document.createElement(type);if(id)
domnode.id=id;if(classname!==null&&classname!=undefined)
domnode.className=classname;return domnode;}
WA.getDomNode=function(domID)
{if(arguments.length>1)
{var elements=[];for(var i=0,l=arguments.length;i<l;i++)
elements.push(WA.toDOM(arguments[i]));return elements;}
if(WA.isString(domID))
return document.getElementById(domID);return null;}
WA.toDOM=function(n)
{if(WA.isDOM(n))
return n;else if(WA.isString(n))
return WA.getDomNode(n);return null;}
WA.get=function(n)
{var self=this;var _nodes=[];if(WA.isString(n))
{switch(n[0])
{case'#':_nodes=[WA.getDomNode(n.substr(1))];break;case'.':if(document.getElementsByClassName)
_nodes=document.getElementsByClassName(n.substr(1));else
{theclass=new RegExp('\\b'+n.substr(1)+'\\b');allnodes=this.getElementsByTagName('*');for(var i=0,l=allnodes.length;i<l;i++)
if(theclass.test(allnodes[i].className))_nodes.push(allnodes[i]);}
break;case'!':_nodes=Array.prototype.slice.call(document.getElementsByName(n.substr(1)));break;default:_nodes=Array.prototype.slice.call(document.getElementsByTagName(n));break;}}
else if(WA.isDOM(n))
_nodes=[n];this.node=function(){return _nodes[0];}
this.nodes=function(){return _nodes;}
this.text=function(t)
{t=t.replace(/\&/g,"&amp;").replace(/\'/g,"&#39;").replace(/\"/g,"&quot;").replace(/</g,"&lt;").replace(/>/g,"&gt;");for(var i=0,l=_nodes.length;i<l;i++)_nodes[i].innerHTML=t;return self;}
this.html=function(t){for(var i=0,l=_nodes.length;i<l;i++)_nodes[i].innerHTML=t;return self;}
this.append=function(t){for(var i=0,l=_nodes.length;i<l;i++)_nodes[i].innerHTML+=t;return self;}
this.css=function(p,v)
{if(v===undefined)
return _nodes[0]?_nodes[0].style[p]:undefined;for(var i=0,l=_nodes.length;i<l;i++)
_nodes[i].style[p]=v;return self;}
this.CSSwidth=function(v){return self.css('width',v);}
this.CSSheight=function(v){return self.css('height',v);}
this.CSSleft=function(v){return self.css('left',v);}
this.CSStop=function(v){return self.css('top',v);}
this.CSSmargin=function(v){return self.css('margin',v);}
this.CSSpadding=function(v){return self.css('padding',v);}
this.CSSborder=function(v){return self.css('border',v);}
this.CSScolor=function(v){return self.css('color',v);}
this.CSSbgcolor=function(v){return self.css('backgroundColor',v);}
this.CSSbg=function(v){return self.css('background',v);}
this.CSSfont=function(v){return self.css('font',v);}
this.CSSdisplay=function(v){return self.css('display',v);}
this.CSSopacity=function(v){self.css('opacity',v/100);return self.css('filter','alpha(opacity: '+v+')');}
this.width=function(v){if(v===undefined)return _nodes[0]?WA.browser.getNodeWidth(_nodes[0]):null;else return self.css('width',WA.isNumber(v)?v+'px':v);}
this.height=function(v){if(v===undefined)return _nodes[0]?WA.browser.getNodeHeight(_nodes[0]):null;else return self.css('height',WA.isNumber(v)?v+'px':v);}
this.left=function(v,n){if(v===undefined)return _nodes[0]?(n===undefined?WA.browser.getNodeDocumentLeft(_nodes[0]):WA.browser.getNodeNodeLeft(_nodes[0],n)):null;else return self.css('left',WA.isNumber(v)?v+'px':v);}
this.top=function(v,n){if(v===undefined)return _nodes[0]?(n===undefined?WA.browser.getNodeDocumentTop(_nodes[0]):WA.browser.getNodeNodeTop(_nodes[0],n)):null;else return self.css('top',WA.isNumber(v)?v+'px':v);}
this.anim=function(s,f){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.createSprite(_nodes[i],s,f);return self;}
this.fadeIn=function(s,f){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.fadeIn(_nodes[i],s,f);return self;}
this.fadeOut=function(s,f){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.fadeOut(_nodes[i],s,f);return self;}
this.openV=function(s,f,h){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.openV(_nodes[i],s,h,f);return self;}
this.closeV=function(s,f,h){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.closeV(_nodes[i],s,h,f);return self;}
this.openH=function(s,f,w){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.openH(_nodes[i],s,w,f);return self;}
this.closeH=function(s,f,w){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.closeH(_nodes[i],s,w,f);return self;}
this.open=function(s,f,w,h){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.open(_nodes[i],s,w,h,f);return self;}
this.close=function(s,f,w,h){if(!WA.Managers.anim)return null;for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.anim.close(_nodes[i],s,w,h,f);return self;}
this.move=function(s,x,y,f,l,t){if(!WA.Managers.anim)return null;for(var i=0,lx=_nodes.length;i<lx;i++)WA.Managers.anim.move(_nodes[i],s,l,t,x,y,f);return self;}
this.on=function(e,f){for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.event.on(e,_nodes[i],f,true);return self;}
this.off=function(e,f){for(var i=0,l=_nodes.length;i<l;i++)WA.Managers.event.off(e,_nodes[i],f,true);return self;}
this.click=function(f){return self.on('click',f);}
this.dblclick=function(f){return self.on('dblclick',f);}
this.mouseover=function(f){return self.on('mouseover',f);}
this.mouseout=function(f){return self.on('mouseout',f);}
this.mousemove=function(f){return self.on('mousemove',f);}
this.mousedown=function(f){return self.on('mousedown',f);}
this.mouseup=function(f){return self.on('mouseup',f);}
this.keydown=function(f){return self.on('keydown',f);}
this.keyup=function(f){return self.on('keyup',f);}
return this;}
WA.i18n=function(){}
WA.i18n.defaulti18n={'json.error':'The JSON code has been parsed with error, it cannot be built.\n','json.unknown':'The JSON core do not know what to do with this unknown type: '};WA.i18n.i18n={};WA.i18n.setEntry=function(id,message)
{WA.i18n.defaulti18n[id]=message;}
WA.i18n.loadMessages=function(messages)
{for(var i in messages)
{if(!WA.isString(messages[i]))
continue;WA.i18n.i18n[i]=messages[i];}}
WA.i18n.getMessage=function(id)
{return WA.i18n.i18n[id]||WA.i18n.defaulti18n[id]||id;}
WA.UTF8=function(){}
WA.UTF8.encode=function(value)
{return value;if(WA.isObject(value))
{var elements={};for(var i in value)
{if(!WA.isString(value[i]))
continue;elements[i]=WA.UTF8.encode(value[i]);}
return elements;}
value=value.replace(/\r\n/g,'\n');var utf='';for(var i=0,l=value.length;i<l;i++)
{var c=value.charCodeAt(i);if(c<128)
{utf+=String.fromCharCode(c);}
else if((c>127)&&(c<2048))
{utf+=String.fromCharCode((c>>6)|192);utf+=String.fromCharCode((c&63)|128);}
else
{utf+=String.fromCharCode((c>>12)|224);utf+=String.fromCharCode(((c>>6)&63)|128);utf+=String.fromCharCode((c&63)|128);}}
return utf;}
WA.UTF8.decode=function(value)
{var str='';var i=0;var c1=c2=c3=0;while(i<value.length)
{c1=value.charCodeAt(i);if(c1<128)
{str+=String.fromCharCode(c1);i++;}
else if((c1>191)&&(c1<224))
{c2=value.charCodeAt(i+1);str+=String.fromCharCode(((c1&31)<<6)|(c2&63));i+=2;}
else
{c2=value.charCodeAt(i+1);c3=value.charCodeAt(i+2);str+=String.fromCharCode(((c1&15)<<12)|((c2&63)<<6)|(c3&63));i+=3;}}
return str;}
WA.Entities=function(){}
WA.Entities.entities={'&#160;':'&nbsp;','&#161;':'&iexcl;','&#162;':'&cent;','&#163;':'&pound;','&#164;':'&curren;','&#165;':'&yen;','&#166;':'&brvbar;','&#167;':'&sect;','&#168;':'&uml;','&#169;':'&copy;','&#170;':'&ordf;','&#171;':'&laquo;','&#172;':'&not;','&#173;':'&shy;','&#174;':'&reg;','&#175;':'&macr;','&#176;':'&deg;','&#177;':'&plusmn;','&#178;':'&sup2;','&#179;':'&sup3;','&#180;':'&acute;','&#181;':'&micro;','&#182;':'&para;','&#183;':'&middot;','&#184;':'&cedil;','&#185;':'&sup1;','&#186;':'&ordm;','&#187;':'&raquo;','&#188;':'&frac14;','&#189;':'&frac12;','&#190;':'&frac34;','&#191;':'&iquest;','&#192;':'&Agrave;','&#193;':'&Aacute;','&#194;':'&Acirc;','&#195;':'&Atilde;','&#196;':'&Auml;','&#197;':'&Aring;','&#198;':'&AElig;','&#199;':'&Ccedil;','&#200;':'&Egrave;','&#201;':'&Eacute;','&#202;':'&Ecirc;','&#203;':'&Euml;','&#204;':'&Igrave;','&#205;':'&Iacute;','&#206;':'&Icirc;','&#207;':'&Iuml;','&#208;':'&ETH;','&#209;':'&Ntilde;','&#210;':'&Ograve;','&#211;':'&Oacute;','&#212;':'&Ocirc;','&#213;':'&Otilde;','&#214;':'&Ouml;','&#215;':'&times;','&#216;':'&Oslash;','&#217;':'&Ugrave;','&#218;':'&Uacute;','&#219;':'&Ucirc;','&#220;':'&Uuml;','&#221;':'&Yacute;','&#222;':'&THORN;','&#223;':'&szlig;','&#224;':'&agrave;','&#225;':'&aacute;','&#226;':'&acirc;','&#227;':'&atilde;','&#228;':'&auml;','&#229;':'&aring;','&#230;':'&aelig;','&#231;':'&ccedil;','&#232;':'&egrave;','&#233;':'&eacute;','&#234;':'&ecirc;','&#235;':'&euml;','&#236;':'&igrave;','&#237;':'&iacute;','&#238;':'&icirc;','&#239;':'&iuml;','&#240;':'&eth;','&#241;':'&ntilde;','&#242;':'&ograve;','&#243;':'&oacute;','&#244;':'&ocirc;','&#245;':'&otilde;','&#246;':'&ouml;','&#247;':'&divide;','&#248;':'&oslash;','&#249;':'&ugrave;','&#250;':'&uacute;','&#251;':'&ucirc;','&#252;':'&uuml;','&#253;':'&yacute;','&#254;':'&thorn;','&#255;':'&yuml;','&#402;':'&fnof;','&#913;':'&Alpha;','&#914;':'&Beta;','&#915;':'&Gamma;','&#916;':'&Delta;','&#917;':'&Epsilon;','&#918;':'&Zeta;','&#919;':'&Eta;','&#920;':'&Theta;','&#921;':'&Iota;','&#922;':'&Kappa;','&#923;':'&Lambda;','&#924;':'&Mu;','&#925;':'&Nu;','&#926;':'&Xi;','&#927;':'&Omicron;','&#928;':'&Pi;','&#929;':'&Rho;','&#931;':'&Sigma;','&#932;':'&Tau;','&#933;':'&Upsilon;','&#934;':'&Phi;','&#935;':'&Chi;','&#936;':'&Psi;','&#937;':'&Omega;','&#945;':'&alpha;','&#946;':'&beta;','&#947;':'&gamma;','&#948;':'&delta;','&#949;':'&epsilon;','&#950;':'&zeta;','&#951;':'&eta;','&#952;':'&theta;','&#953;':'&iota;','&#954;':'&kappa;','&#955;':'&lambda;','&#956;':'&mu;','&#957;':'&nu;','&#958;':'&xi;','&#959;':'&omicron;','&#960;':'&pi;','&#961;':'&rho;','&#962;':'&sigmaf;','&#963;':'&sigma;','&#964;':'&tau;','&#965;':'&upsilon;','&#966;':'&phi;','&#967;':'&chi;','&#968;':'&psi;','&#969;':'&omega;','&#977;':'&thetasym;','&#978;':'&upsih;','&#982;':'&piv;','&#8226;':'&bull;','&#8230;':'&hellip;','&#8242;':'&prime;','&#8243;':'&Prime;','&#8254;':'&oline;','&#8260;':'&frasl;','&#8472;':'&weierp;','&#8465;':'&image;','&#8476;':'&real;','&#8482;':'&trade;','&#8501;':'&alefsym;','&#8592;':'&larr;','&#8593;':'&uarr;','&#8594;':'&rarr;','&#8595;':'&darr;','&#8596;':'&harr;','&#8629;':'&crarr;','&#8656;':'&lArr;','&#8657;':'&uArr;','&#8658;':'&rArr;','&#8659;':'&dArr;','&#8660;':'&hArr;','&#8704;':'&forall;','&#8706;':'&part;','&#8707;':'&exist;','&#8709;':'&empty;','&#8711;':'&nabla;','&#8712;':'&isin;','&#8713;':'&notin;','&#8715;':'&ni;','&#8719;':'&prod;','&#8721;':'&sum;','&#8722;':'&minus;','&#8727;':'&lowast;','&#8730;':'&radic;','&#8733;':'&prop;','&#8734;':'&infin;','&#8736;':'&ang;','&#8743;':'&and;','&#8744;':'&or;','&#8745;':'&cap;','&#8746;':'&cup;','&#8747;':'&int;','&#8756;':'&there4;','&#8764;':'&sim;','&#8773;':'&cong;','&#8776;':'&asymp;','&#8800;':'&ne;','&#8801;':'&equiv;','&#8804;':'&le;','&#8805;':'&ge;','&#8834;':'&sub;','&#8835;':'&sup;','&#8836;':'&nsub;','&#8838;':'&sube;','&#8839;':'&supe;','&#8853;':'&oplus;','&#8855;':'&otimes;','&#8869;':'&perp;','&#8901;':'&sdot;','&#8968;':'&lceil;','&#8969;':'&rceil;','&#8970;':'&lfloor;','&#8971;':'&rfloor;','&#9001;':'&lang;','&#9002;':'&rang;','&#9674;':'&loz;','&#9824;':'&spades;','&#9827;':'&clubs;','&#9829;':'&hearts;','&#9830;':'&diams;','&#34;':'&quot;','&#38;':'&amp;','&#60;':'&lt;','&#61;':'&gt;','&#338;':'&OElig;','&#339;':'&oelig;','&#352;':'&Scaron;','&#353;':'&scaron;','&#376;':'&Yuml;','&#710;':'&circ;','&#732;':'&tilde;','&#8194;':'&ensp;','&#8195;':'&emsp;','&#8201;':'&thinsp;','&#8204;':'&zwnj;','&#8205;':'&zwj;','&#8206;':'&lrm;','&#8207;':'&rlm;','&#8211;':'&ndash;','&#8212;':'&mdash;','&#8216;':'&lsquo;','&#8217;':'&rsquo;','&#8218;':'&sbquo;','&#8220;':'&ldquo;','&#8221;':'&rdquo;','&#8222;':'&bdquo;','&#8224;':'&dagger;','&#8225;':'&Dagger;','&#8240;':'&permil;','&#8249;':'&lsaquo;','&#8250;':'&rsaquo;','&#8364;':'&euro;'}
WA.Entities.rentities=null;WA.Entities.encode=function(str,numeric)
{if(WA.isEmpty(str))
return str;var enc='',c='';for(var i=0,l=str.length;i<l;i++)
{c=str.charAt(i);if(c<' '||c>'~'||c=='"'||c=='&'||c=='<'||c=='>')
{c='&#'+c.charCodeAt()+';';if(!numeric&&WA.Entities.entities[c])
c=WA.Entities.entities[c];}
enc+=c;}
return enc;}
WA.Entities.decode=function(str)
{if(WA.isEmpty(str))
return str;ent=str.match(/&#[a-zA-Z0-9]{1,8};/g);if(ent==null)
return str;if(WA.Entities.rentities==null)
{for(var i in WA.Entities.entities)
{WA.Entities.rentities[WA.Entities.entities[i]]=i;}}
for(var c='',n=0,i=0,l=ent.length;i<l;i++)
{c=ent[i];if(WA.Entities.rentities[c])
c=WA.Entities.rentities[c];if(c.substring(0,2)!='&#')
continue;n=Math.parseInt(c.substring(2,c.length-1),10);if(n>=-32768&&n<=65535)
{str=str.replace(c,String.fromCharCode(n));}}
return str;}
WA.debug=function(){}
WA.debug.Console=null;WA.debug.Level=4;WA.debug.filter=null;WA.debug.explain=function(message,level)
{if(!level)
level=3;if((!WA.debug.Console&&!window.console)||level<WA.debug.Level)
return;if(typeof WA.debug.filter=='array')
{var visible=false;for(var i in WA.debug.filter)
{if(!WA.isString(WA.debug.filter[i]))
continue;if(message.match(WA.debug.filter[i]))
{visible=true;break;}}
if(!visible)
return;}
if(WA.isObject(message))
{var txt='';for(var i in message)
txt+=i+': '+message[i];message=txt;}
if(console&&console.log)
console.log(message);if(window.console&&window.console.firebug&&!WA.debug.Console)
window.console.log(message);else if(WA.debug.Console&&WA.debug.Console.write)
WA.debug.Console.write(message+'<br />');else if(WA.debug.Console)
WA.debug.Console.innerHTML+=message+'<br />';}
WA.JSON=function(){}
WA.JSON.withalert=false;WA.JSON.decode=function(json,execerror)
{var code=null;try
{code=eval('('+json+')');}
catch(e)
{if(WA.JSON.withalert)
alert(WA.i18n.getMessage('json.error')+e.message+'\n'+json);throw e;}
if(code.debug)
{WA.debug.explain(code.system,3);code=code.code;}
if(execerror&&code.error&&!code.login)
{WA.debug.explain(code.messages,3);code=null;}
return code;}
WA.JSON.encode=function(data)
{var json='';if(WA.isArray(data))
{json+='[';var item=0;for(var i=0,l=data.length;i<l;i++)
{json+=(item++?',':'')+WA.JSON.encode(data[i]);}
json+=']';}
else if(data===null)
{json+='null';}
else if(!WA.isDefined(data))
{json+='undefined';}
else if(WA.isNumber(data))
{json+=data;}
else if(WA.isString(data))
{json+='"'+(data.replace(/\\/g,"\\\\").replace(/"/g,"\\\"").replace(/\n/g,"\\n"))+'"';}
else if(WA.isObject(data))
{json+='{';var item=0;for(var i in data)
{if(WA.isFunction(data[i]))
continue;json+=(item++?',':'')+'"'+i+'":'+WA.JSON.encode(data[i]);}
json+='}';}
else if(WA.isBool(data))
{json+=data?'true':'false';}
else
{if(WA.JSON.withalert)
alert(WA.i18n.getMessage('json.unknown')+typeof data);}
return json;}
WA.browser=function()
{var agent=navigator.userAgent.toUpperCase();WA.browser.isCompat=(document.compatMode=='CSS1Compat');WA.browser.isOpera=agent.indexOf('OPERA')>-1;WA.browser.isChrome=agent.indexOf('CHROME')>-1;WA.browser.isFirefox=agent.indexOf('FIREFOX')>-1;WA.browser.isFirebug=(WA.isDefined(window.console)&&WA.isDefined(window.console.firebug));WA.browser.isSafari=!WA.browser.isChrome&&agent.indexOf('SAFARI')>-1;WA.browser.isSafari2=WA.browser.isSafari&&agent.indexOf('APPLEWEBKIT/4')>-1;WA.browser.isSafari3=WA.browser.isSafari&&agent.indexOf('VERSION/3')>-1;WA.browser.isSafari4=WA.browser.isSafari&&agent.indexOf('VERSION/4')>-1;WA.browser.isMSIE=!WA.browser.isOpera&&agent.indexOf('MSIE')>-1;WA.browser.isMSIE7=WA.browser.isMSIE&&agent.indexOf('MSIE 7')>-1;WA.browser.isMSIE8=WA.browser.isMSIE&&agent.indexOf('MSIE 8')>-1;WA.browser.isMSIE9=WA.browser.isMSIE&&agent.indexOf('MSIE 9')>-1;WA.browser.isMSIE6=WA.browser.isMSIE&&!WA.browser.isMSIE7&&!WA.browser.isMSIE8&&!WA.browser.isMSIE9;WA.browser.isWebKit=agent.indexOf('WEBKIT')>-1;WA.browser.isGecko=!WA.browser.isWebKit&&agent.indexOf('GECKO')>-1;WA.browser.isGecko2=WA.browser.isGecko&&agent.indexOf('RV:1.8')>-1;WA.browser.isGecko3=WA.browser.isGecko&&agent.indexOf('RV:1.9')>-1;WA.browser.isLinux=agent.indexOf('LINUX')>-1;WA.browser.isWindows=!!agent.match(/WINDOWS|WIN32/);WA.browser.isMac=!!agent.match(/MACINTOSH|MAC OS X/);WA.browser.isAir=agent.indexOf('ADOBEAIR')>-1;WA.browser.isDom=document.getElementById&&document.childNodes&&document.createElement;WA.browser.isBoxModel=WA.browser.isMSIE&&!WA.browser.isCompat;WA.browser.isSecure=(window.location.href.toUpperCase().indexOf('HTTPS')==0);WA.browser.normalizedMouseButton=WA.browser.isMSIE?{1:0,2:2,4:1}:(WA.browser.isSafari2?{1:0,2:1,3:2}:{0:0,1:1,2:2});if(WA.browser.isMSIE6)
try{document.execCommand('BackgroundImageCache',false,true);}catch(e){}}
WA.browser.getDocumentWidth=function()
{if(WA.browser.isMSIE6)
return document.body.scrollWidth;return document.documentElement.scrollWidth;}
WA.browser.getDocumentHeight=function()
{if(WA.browser.isMSIE6)
return document.body.scrollHeight;return document.documentElement.scrollHeight;}
WA.browser.getWindowWidth=function()
{if(!WA.browser.isMSIE)
return window.innerWidth;if(document.documentElement&&document.documentElement.clientWidth)
return document.documentElement.clientWidth;if(document.body&&document.body.clientWidth)
return document.body.clientWidth;return 0;}
WA.browser.getWindowHeight=function()
{if(!WA.browser.isMSIE)
return window.innerHeight;if(document.documentElement&&document.documentElement.clientHeight)
return document.documentElement.clientHeight;if(document.body&&document.body.clientHeight)
return document.body.clientHeight;return 0;}
WA.browser.getScreenWidth=function()
{return screen.width;}
WA.browser.getScreenHeight=function()
{return screen.height;}
WA.browser.getScrollLeft=function()
{if(WA.browser.isDom)
return document.documentElement.scrollLeft;if(document.body&&document.body.scrollLeft)
return document.body.scrollLeft;if(typeof window.pageXOffset=='number')
return window.pageXOffset;return 0;}
WA.browser.getScrollTop=function()
{if(typeof window.pageYOffset=='number')
return window.pageYOffset;if(typeof window.scrollY=='number')
return window.scrollY;if(document.body&&document.body.scrollTop)
return document.body.scrollTop;if(WA.browser.isDom)
return document.body.scrollTop;return 0;}
WA.browser.getScrollWidth=function()
{return WA.browser.getDocumentWidth();}
WA.browser.getScrollHeight=function()
{return WA.browser.getDocumentHeight();}
WA.browser.getNodeDocumentLeft=function(node)
{var l=node.offsetLeft;if(node.offsetParent!=null)
l+=WA.browser.getNodeDocumentLeft(node.offsetParent)+WA.browser.getNodeBorderLeftWidth(node.offsetParent)+WA.browser.getNodeMarginLeftWidth(node.offsetParent);return l;}
WA.browser.getNodeDocumentTop=function(node)
{var t=node.offsetTop;if(node.offsetParent!=null)
t+=WA.browser.getNodeDocumentTop(node.offsetParent)+WA.browser.getNodeBorderTopHeight(node.offsetParent)+WA.browser.getNodeMarginTopHeight(node.offsetParent);return t;}
WA.browser.getNodeNodeLeft=function(node,refnode)
{if(!node)
return null;var l=node.offsetLeft;if(node.offsetParent!=null&&node.offsetParent!=refnode)
l+=WA.browser.getNodeBorderLeftWidth(node.offsetParent)+WA.browser.getNodeNodeLeft(node.offsetParent,refnode);return l;}
WA.browser.getNodeNodeTop=function(node,refnode)
{if(!node)
return null;var t=node.offsetTop;if(node.offsetParent!=null&&node.offsetParent!=refnode)
t+=WA.browser.getNodeBorderTopHeight(node.offsetParent)+WA.browser.getNodeNodeTop(node.offsetParent,refnode);return t;}
WA.browser.getNodeScrollLeft=function(node)
{if(WA.browser.isDom)
return node.scrollLeft;if(typeof node.pageXOffset=='number')
return node.pageXOffset;return 0;}
WA.browser.getNodeScrollTop=function(node)
{if(WA.browser.isDom)
return node.scrollTop;if(typeof node.pageYOffset=='number')
return node.pageYOffset;return 0;}
WA.browser.getNodeScrollWidth=function(node)
{return WA.browser.getDocumentWidth();}
WA.browser.getNodeScrollHeight=function(node)
{return WA.browser.getDocumentHeight();}
WA.browser.getNodeMarginLeftWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.marginLeft,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('margin-left'))||0;}
WA.browser.getNodeMarginRightWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.marginRight,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('margin-right'))||0;}
WA.browser.getNodeMarginWidth=function(node)
{return WA.browser.getNodeMarginLeftWidth(node)+WA.browser.getNodeMarginRightWidth(node);}
WA.browser.getNodeMarginTopHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.marginTop,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('margin-top'))||0;}
WA.browser.getNodeMarginBottomHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.marginBottom,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('margin-bottom'))||0;}
WA.browser.getNodeMarginHeight=function(node)
{return WA.browser.getNodeMarginTopHeight(node)+WA.browser.getNodeMarginBottomHeight(node);}
WA.browser.getNodeBorderLeftWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.borderLeftWidth,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('border-left-width'))||0;}
WA.browser.getNodeBorderRightWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.borderRightWidth,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('border-right-width'))||0;}
WA.browser.getNodeBorderWidth=function(node)
{return WA.browser.getNodeBorderLeftWidth(node)+WA.browser.getNodeBorderRightWidth(node);}
WA.browser.getNodeBorderTopHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.borderTopWidth,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('border-top-width'))||0;}
WA.browser.getNodeBorderBottomHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.borderBottomWidth,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('border-bottom-width'))||0;}
WA.browser.getNodeBorderHeight=function(node)
{return WA.browser.getNodeBorderTopHeight(node)+WA.browser.getNodeBorderBottomHeight(node);}
WA.browser.getNodePaddingLeftWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.paddingLeft,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('padding-left'))||0;}
WA.browser.getNodePaddingRightWidth=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.paddingRight,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('padding-right'))||0;}
WA.browser.getNodePaddingWidth=function(node)
{return WA.browser.getNodePaddingLeftWidth(node)+WA.browser.getNodePaddingRightWidth(node);}
WA.browser.getNodePaddingTopHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.paddingTop,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('padding-top'))||0;}
WA.browser.getNodePaddingBottomHeight=function(node)
{return WA.browser.isMSIE?parseInt(node.currentStyle.paddingBottom,10)||0:parseInt(window.getComputedStyle(node,null).getPropertyValue('padding-bottom'))||0;}
WA.browser.getNodePaddingHeight=function(node)
{return WA.browser.getNodePaddingTopHeight(node)+WA.browser.getNodePaddingBottomHeight(node);}
WA.browser.getNodeExternalLeftWidth=function(node)
{return WA.browser.getNodeMarginLeftWidth(node)+WA.browser.getNodeBorderLeftWidth(node);}
WA.browser.getNodeExternalRightWidth=function(node)
{return WA.browser.getNodeMarginRightWidth(node)+WA.browser.getNodeBorderRightWidth(node);}
WA.browser.getNodeExternalWidth=function(node)
{return WA.browser.getNodeExternalLeftWidth(node)+WA.browser.getNodeExternalRightWidth(node);}
WA.browser.getNodeExternalTopHeight=function(node)
{return WA.browser.getNodeMarginTopHeight(node)+WA.browser.getNodeBorderTopHeight(node);}
WA.browser.getNodeExternalBottomHeight=function(node)
{return WA.browser.getNodeMarginBottomHeight(node)+WA.browser.getNodeBorderBottomHeight(node);}
WA.browser.getNodeExternalHeight=function(node)
{return WA.browser.getNodeExternalTopHeight(node)+WA.browser.getNodeExternalBottomHeight(node);}
WA.browser.getNodeExtraLeftWidth=function(node)
{return WA.browser.getNodeMarginLeftWidth(node)+WA.browser.getNodeBorderLeftWidth(node)+WA.browser.getNodePaddingLeftWidth(node);}
WA.browser.getNodeExtraRightWidth=function(node)
{return WA.browser.getNodeMarginRightWidth(node)+WA.browser.getNodeBorderRightWidth(node)+WA.browser.getNodePaddingRightWidth(node);}
WA.browser.getNodeExtraWidth=function(node)
{return WA.browser.getNodeExtraLeftWidth(node)+WA.browser.getNodeExtraRightWidth(node);}
WA.browser.getNodeExtraTopHeight=function(node)
{return WA.browser.getNodeMarginTopHeight(node)+WA.browser.getNodeBorderTopHeight(node)+WA.browser.getNodePaddingTopHeight(node);}
WA.browser.getNodeExtraBottomHeight=function(node)
{return WA.browser.getNodeMarginBottomHeight(node)+WA.browser.getNodeBorderBottomHeight(node)+WA.browser.getNodePaddingBottomHeight(node);}
WA.browser.getNodeExtraHeight=function(node)
{return WA.browser.getNodeExtraTopHeight(node)+WA.browser.getNodeExtraBottomHeight(node);}
WA.browser.getNodeWidth=function(node)
{return WA.browser.getNodeOffsetWidth(node)-WA.browser.getNodePaddingWidth(node)-WA.browser.getNodeBorderWidth(node);}
WA.browser.getNodeHeight=function(node)
{return WA.browser.getNodeOffsetHeight(node)-WA.browser.getNodePaddingHeight(node)-WA.browser.getNodeBorderHeight(node);}
WA.browser.getNodeInnerWidth=function(node)
{return WA.browser.getNodeOffsetWidth(node)-WA.browser.getNodeBorderWidth(node);}
WA.browser.getNodeInnerHeight=function(node)
{return WA.browser.getNodeOffsetHeight(node)-WA.browser.getNodeBorderHeight(node);}
WA.browser.getNodeOffsetWidth=function(node)
{return parseInt(node.offsetWidth,10)||0;}
WA.browser.getNodeOffsetHeight=function(node)
{return parseInt(node.offsetHeight,10)||0;}
WA.browser.getNodeOuterWidth=function(node)
{return WA.browser.getNodeOffsetWidth(node)+WA.browser.getNodeMarginWidth(node);}
WA.browser.getNodeOuterHeight=function(node)
{return WA.browser.getNodeOffsetHeight(node)+WA.browser.getNodeMarginHeight(node);}
WA.browser.getCursorNode=function(e)
{var ev=e||window.event;if(ev.target)return ev.target;if(ev.srcElement)return ev.srcElement;return null;}
WA.browser.getCursorDocumentX=function(e)
{var ev=e||window.event;return ev.pageX-(document.documentElement.clientLeft||0);}
WA.browser.getCursorDocumentY=function(e)
{var ev=e||window.event;return ev.pageY-(document.documentElement.clientTop||0);}
WA.browser.getTouchDocumentX=function(e)
{var ev=e||window.event;var touchobj=event.changedTouches[0];return touchobj.pageX;}
WA.browser.getTouchDocumentY=function(e)
{var ev=e||window.event;var touchobj=event.changedTouches[0];return touchobj.pageY;}
WA.browser.getCursorWindowX=function(e)
{var ev=e||window.event;return ev.clientX-(document.documentElement.clientLeft||0);}
WA.browser.getCursorWindowY=function(e)
{var ev=e||window.event;return ev.clientY-(document.documentElement.clientLeft||0);}
WA.browser.getCursorOffsetX=function(e)
{var offset=0;if(WA.browser.isMSIE||WA.browser.isOpera)
offset=WA.browser.getNodeBorderLeftWidth(WA.browser.getCursorNode(e));var ev=e||window.event;if(typeof(ev.offsetX)=='number')
return ev.offsetX+offset;if(typeof(ev.layerX)=='number')
return ev.layerX+offset;return 0;}
WA.browser.getCursorOffsetY=function(e)
{var offset=0;if(WA.browser.isMSIE||WA.browser.isOpera)
offset=WA.browser.getNodeBorderTopHeight(WA.browser.getCursorNode(e));var ev=e||window.event;if(typeof(ev.offsetY)=='number')
return ev.offsetY+offset;if(typeof(ev.layerY)=='number')
return ev.layerY+offset;return 0;}
WA.browser.getCursorInnerX=function(e)
{var offset=0;if(!WA.browser.isMSIE&&!WA.browser.isOpera)
offset=WA.browser.getNodeBorderLeftWidth(WA.browser.getCursorNode(e));var ev=e||window.event;if(typeof(ev.layerX)=='number')
return ev.layerX-offset;if(typeof(ev.offsetX)=='number')
return ev.offsetX-offset;return 0;}
WA.browser.getCursorInnerY=function(e)
{var offset=0;if(!WA.browser.isMSIE&&!WA.browser.isOpera)
offset=WA.browser.getNodeBorderTopHeight(WA.browser.getCursorNode(e));var ev=e||window.event;if(typeof(ev.layerY)=='number')
return ev.layerY-offset;if(typeof(ev.offsetY)=='number')
return ev.offsetY-offset;return 0;}
WA.browser.getButtonClick=function(e)
{var ev=e||window.event;if(ev.type!='click'&&ev.type!='dblclick')
return false;var button=ev.button?WA.browser.normalizedMouseButton[ev.button]:(ev.which?ev.which-1:0);return button;}
WA.browser.getButtonPressed=function(e)
{var ev=e||window.event;if(ev.type!='mousedown'&&ev.type!='mouseup')
return false;var button=ev.button?WA.browser.normalizedMouseButton[ev.button]:(ev.which?ev.which-1:false);return button;}
WA.browser.getWheel=function(e)
{var ev=e||window.event;if(ev.type!='DOMMouseScroll'&&ev.type!='mousewheel')
return false;var delta=0;if(ev.wheelDelta)
{delta=ev.wheelDelta/120;}
else if(ev.detail)
{delta=-ev.detail/3;}
return delta;}
WA.browser.cancelEvent=function(e)
{var ev=e||window.event;if(!ev)
return false;if(ev.stopPropagation)
ev.stopPropagation();if(ev.preventDefault)
ev.preventDefault();if(ev.stopEvent)
ev.stopEvent();if(WA.browser.isMSIE)window.event.keyCode=0;ev.cancel=true;ev.cancelBubble=true;ev.returnValue=false;return false;}
WA.browser.getKey=function(e)
{var ev=e||window.event;if(ev.type!='keydown'&&ev.type!='keyup')
return false;return ev.keyCode||ev.which;}
WA.browser.getChar=function(e)
{var ev=e||window.event;if(ev.type!='keypress')
return false;return String.fromCharCode(ev.charCode?ev.charCode:ev.keyCode);}
WA.browser.ifShift=function(e)
{var ev=e||window.event;return ev.shiftKey;}
WA.browser.ifCtrl=function(e)
{var ev=e||window.event;return ev.ctrlKey||ev.metaKey;}
WA.browser.ifAlt=function(e)
{var ev=e||window.event;return ev.altKey;}
WA.browser.ifModifier=function(e)
{var ev=e||window.event;return(ev.altKey||ev.ctrlKey||ev.metaKey||ev.shiftKey)?true:false;}
WA.browser.ifNavigation=function(e)
{var c=WA.browser.getKey(e);return((c>=33&&c<=40)||c==9||c==13||c==27)?true:false;}
WA.browser.ifFunction=function(e)
{var c=WA.browser.getKey(e);return(c>=112&&c<=123)?true:false;}
WA.browser.getSelectionRange=function(node,selectionStart,selectionEnd)
{if(node.setSelectionRange)
{node.focus();node.setSelectionRange(selectionStart,selectionEnd);}
else if(node.createTextRange)
{var range=node.createTextRange();range.collapse(true);range.moveEnd('character',selectionEnd);range.moveStart('character',selectionStart);range.select();}}
WA.browser.setInnerHTML=function(node,content)
{if(WA.browser.isGecko)
{var rng=document.createRange();rng.setStartBefore(node);var htmlFrag=rng.createContextualFragment(content);while(node.hasChildNodes())
node.removeChild(node.lastChild);node.appendChild(htmlFrag);}
else
{node.innerHTML=content;}}
WA.render=function()
{}
WA.render.Integer=function(data,sep)
{if(!sep)
return data;data=''+data;var rgx=/(\d+)(\d{3})/;while(rgx.test(data))
{data=data.replace(rgx,'$1'+sep+'$2');}
return data;}
WA.render.Fixed=function(data,fix,dec,sep)
{if(!WA.isNumber(fix))fix=2;if(!dec)dex='.';if(!sep)sep=',';data=data.toFixed(fix);data+='';x=data.split('.');x1=x[0];x2=x.length>1?dec+x[1]:'';var rgx=/(\d+)(\d{3})/;while(rgx.test(x1))
{x1=x1.replace(rgx,'$1'+sep+'$2');}
return x1+x2;}
WA.render.Money=function(data,symbol,fix,dec,sep)
{return symbol+WA.render.Fixed(data,fix,dec,sep);}
WA.Managers={};WA.RGB=function(color)
{var self=this;this.ok=false;if(color.charAt(0)=='#')
color=color.substr(1,6);color=color.replace(/ /,'').toLowerCase();var htmlcolors={black:'000000',silver:'c0c0c0',gray:'808080',white:'ffffff',maroon:'800000',red:'ff0000',purple:'800080',fuchsia:'ff00ff',green:'008000',lime:'00ff00',olive:'808000',yellow:'ffff00',navy:'000080',blue:'0000ff',teal:'008080',aqua:'00ffff'};for(var name in htmlcolors)
{if(WA.isString(htmlcolors[name])&&color==name)
{this.name=color;color=htmlcolors[name];}}
var rgb=/^rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)$/.exec(color);if(rgb)
{this.red=parseInt(rgb[1],10);this.green=parseInt(rgb[2],10);this.blue=parseInt(rgb[3],10);this.ok=true;}
else
{rgb=/^(\w{2})(\w{2})(\w{2})$/.exec(color);if(rgb)
{this.red=parseInt(rgb[1],16);this.green=parseInt(rgb[2],16);this.blue=parseInt(rgb[3],16);this.ok=true;}
else
{rgb=/^(\w{1})(\w{1})(\w{1})$/.exec(color);if(rgb)
{this.red=parseInt(rgb[1]+rgb[1],16);this.green=parseInt(rgb[2]+rgb[2],16);this.blue=parseInt(rgb[3]+rgb[3],16);this.ok=true;}}}
this.red=(this.red<0||isNaN(this.red))?0:((this.red>255)?255:this.red);this.green=(this.green<0||isNaN(this.green))?0:((this.green>255)?255:this.green);this.blue=(this.blue<0||isNaN(this.blue))?0:((this.blue>255)?255:this.blue);this.toRGB=toRGB;function toRGB()
{return'rgb('+self.red+', '+self.green+', '+self.blue+')';}
this.toHex=toHex;function toHex()
{var red=self.red.toString(16);var green=self.green.toString(16);var blue=self.blue.toString(16);if(red.length==1)red='0'+red;if(green.length==1)green='0'+green;if(blue.length==1)blue='0'+blue;return'#'+red+green+blue;}}
WA.start=function()
{WA.browser();WA.running=true;}
WA.start();WA.nothing=function(){};WA.Date.setNames(['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],['Dom','Lun','Mar','Mie','Jue','Vie','Sab'],['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic']);WA.templates={};WA.templater=function(strings,...keys)
{return function(data)
{let temp=strings.slice();keys.forEach((key,i)=>{temp[i]=temp[i]+data[key];});return temp.join('');}};WA.Managers.event=new function()
{var self=this;listenerid=1;functionid=1;events={};beforeflushs=[];flushs=[];keys=[];this.keys=keys;specialkeys={'esc':27,'escape':27,'tab':9,'space':32,'return':13,'enter':13,'scrolllock':145,'capslock':20,'numlock':144,'pause':19,'break':19,'insert':45,'delete':46,'backspace':8,'home':36,'end':35,'pageup':33,'pagedown':34,'left':37,'up':38,'right':39,'down':40,'f1':112,'f2':113,'f3':114,'f4':115,'f5':116,'f6':117,'f7':118,'f8':119,'f9':120,'f10':121,'f11':122,'f12':123,'(shift)':16,'(control)':17,'(alt)':18};this.addListener=this.on=this.add=this.start=this.listen=this.attachEvent=this.registerEvent=addListener;function addListener(eventname,eventnode,eventfunction,eventcapture)
{eventnode=WA.toDOM(eventnode);if(!eventnode)
return false;WA.debug.explain('eventManager.addListener('+eventname+', '+eventnode.id+')');if(eventnode.listeneruid==undefined)
eventnode.listeneruid=listenerid++;if(eventfunction.functionuid==undefined)
eventfunction.functionuid=functionid++;if(events[eventnode.listeneruid]==undefined)
events[eventnode.listeneruid]={};if(events[eventnode.listeneruid][eventname]==undefined)
events[eventnode.listeneruid][eventname]={};eventnode.context=WA.context;thefunction=function()
{if(WA.context!=undefined)
{var xid=oldcontext=null;if(this.id&&this.id.indexOf('|')!=-1)
{xid=WA.parseID(this.id);oldcontext=WA.context=xid[0]+'|'+xid[1]+'|';}}
var ret=eventfunction.apply(this,arguments);if(WA.context!=undefined)
{if(xid)
WA.context=oldcontext;}
return ret;}
if(eventnode!=window&&eventname=='load'&&WA.browser.isMSIE)
{thefunction=function(e)
{if(this.readyState!='complete'&&this.readyState!='loaded')
return null;var xid=oldcontext=null;if(this.id&&this.id.indexOf('|')!=-1)
{xid=WA.parseID(this.id);oldcontext=WA.context=xid[0]+'|'+xid[1]+'|';}
var ret=eventfunction.apply(this,arguments);if(xid)
WA.context=oldcontext;return ret;};eventnode.onreadystatechange=thefunction;}
else if(eventnode.addEventListener)
{if(eventname=='mousewheel')
{eventnode.addEventListener('DOMMouseScroll',thefunction,eventcapture);}
eventnode.addEventListener(eventname,thefunction,eventcapture);}
else if(eventnode.attachEvent)
{eventnode.attachEvent('on'+eventname,thefunction);}
else
{eventnode['on'+eventname]=thefunction;}
events[eventnode.listeneruid][eventname][eventfunction.functionuid]=[eventnode,thefunction,eventcapture];return true;}
this.removeListener=this.off=this.remove=this.stop=this.detachEvent=removeListener;function removeListener(eventname,eventnode,eventfunction,eventcapture)
{eventnode=WA.toDOM(eventnode);if(!eventnode)
return;WA.debug.explain('eventManager.removeListener('+eventname+', '+eventnode.id+')');if(eventnode.listeneruid==undefined)
return;if(eventfunction.functionuid==undefined)
return;if(events[eventnode.listeneruid]==undefined)
return;if(events[eventnode.listeneruid][eventname]==undefined)
return;if(events[eventnode.listeneruid][eventname][eventfunction.functionuid]==undefined)
return;if(eventname=='load'&&WA.browser.isMSIE)
{eventnode.onreadystatechange=WA.nothing;}
else if(eventnode.removeEventListener)
{if(eventname=='mousewheel')
{eventnode.removeEventListener('DOMMouseScroll',events[eventnode.listeneruid][eventname][eventfunction.functionuid],eventcapture);}
eventnode.removeEventListener(eventname,events[eventnode.listeneruid][eventname][eventfunction.functionuid],eventcapture);}
else if(eventnode.detachEvent)
{eventnode.detachEvent('on'+eventname,events[eventnode.listeneruid][eventname][eventfunction.functionuid]);}
else
{eventnode['on'+eventname]=null;}
delete events[eventnode.listeneruid][eventname][eventfunction.functionuid];}
this.addKey=this.key=addKey;function addKey(key,callback)
{WA.debug.explain('eventManager.addKey('+key+')');var xkey=key.toLowerCase().split("+");for(var i=0,l=xkey.length;i<l;i++)
{if(xkey[i]=='shift'||xkey[i]=='control'||xkey[i]=='ctrl'||xkey[i]=='alt')
continue;if(specialkeys[xkey[i]]!=undefined)
continue;xkey[i]=xkey[i].charAt(0);}
var data={skey:key,key:xkey,callback:callback};keys.push(data);}
this.removeKey=removeKey;function removeKey(key)
{WA.debug.explain('eventManager.removeKey('+key+')');for(var i=0,l=keys.length;i<l;i++)
if(keys[i].skey==key)
keys.splice(i,1);}
function keycallbackdown(e)
{keycallback(e,'down');}
function keycallbackup(e)
{keycallback(e,'up');}
function keycallback(e,type)
{var code=WA.browser.getKey(e);var c=String.fromCharCode(code).toLowerCase();var shift=WA.browser.ifShift(e);var ctrl=WA.browser.ifCtrl(e);var alt=WA.browser.ifAlt(e);for(var i=0,l=keys.length;i<l;i++)
{var isok=0;for(var j=0,m=keys[i]['key'].length;j<m;j++)
{if(keys[i]['key'][j]=='shift'&&shift)
isok++;else if(keys[i]['key'][j]=='alt'&&alt)
isok++;else if(keys[i]['key'][j]=='control'&&ctrl)
isok++;else if(specialkeys[keys[i]['key'][j]]==code)
isok++;else if(keys[i]['key'][j]===c)
isok++;}
if(isok==keys[i]['key'].length)
{keys[i]['callback'](e,keys[i]['skey'],type);}}}
this.registerBeforeFlush=registerBeforeFlush;function registerBeforeFlush(functionflush)
{beforeflushs.push(functionflush);}
this.registerFlush=registerFlush;function registerFlush(functionflush)
{flushs.push(functionflush);}
this.unregisterBeforeFlush=unregisterBeforeFlush;function unregisterBeforeFlush(functionflush)
{beforeflushs.remove(functionflush);}
this.unregisterFlush=unregisterFlush;function unregisterFlush(functionflush)
{flushs.remove(functionflush);}
function _beforeflush(e)
{var result='';for(var i=0,l=beforeflushs.length;i<l;i++)
{result+=beforeflushs[i](e);}
if(result!='')
{WA.browser.cancelEvent(e);e.returnValue=result;return result;}}
function _flush(e)
{for(var i=0,l=flushs.length;i<l;i++)
{flushs[i](e);flushs[i]=null;}
for(i in events)
{for(j in events[i])
{for(k in events[i][j])
{if(events[i][j][k][0])
{if(j=='mousewheel')
{events[i][j][k][0].removeEventListener('DOMMouseScroll',events[i][j][k][1],events[i][j][k][2]);}
events[i][j][k][0].removeEventListener(j,events[i][j][k][1],events[i][j][k][2]);}
else if(events[i][j][k][0].detachEvent)
{events[i][j][k][0].detachEvent('on'+j,events[i][j][k][1]);}
else
{events[i][j][k][0]['on'+j]=null;}}}}
delete events;delete beforeflushs;delete flushs;delete keys;self=null;}
this.addListener('beforeunload',window,_beforeflush,false);this.addListener('unload',window,_flush,false);this.addListener('keydown',document,keycallbackdown,false);this.addListener('keyup',document,keycallbackup,false);}();WA.Managers.ajax=new function()
{var self=this;this.requests=[];this.listener=null;this.stateFeedBack=null;this.timeoutabort=0;this.setListener=setListener;function setListener(listener)
{self.listener=listener;}
this.addStateFeedback=addStateFeedback;function addStateFeedback(statefeedback,timeoutabort)
{self.statefeedback=statefeedback;if(timeoutabort)
self.timeoutabort=timeoutabort;}
this.setTimeout=setTimeout;function setTimeout(timeoutabort)
{self.timeoutabort=timeoutabort;}
function callNotify(event)
{if(self.listener)
{self.listener(event);}}
this.createRequest=createRequest;function createRequest(url,method,data,feedback,dosend)
{callNotify('create');var r=new WA.Managers.ajax.Request(url,method,data,feedback,dosend,self.listener,self.statefeedback,self.timeoutabort);if(r)
{self.requests.push(r);}
return r;}
this.createPromiseRequest=createPromiseRequest;function createPromiseRequest(data)
{var prom=new Promise(function(resolve,reject)
{try
{callNotify('create');var r=new WA.Managers.ajax.PromiseRequest(data,self.listener,self.timeoutabort);resolve(r);}
catch(e)
{callNotify('error-create');reject(e);}});return prom;}
this.createPeriodicRequest=createPeriodicRequest;function createPeriodicRequest(period,times,url,method,data,feedback,dosend)
{callNotify('create');var r=new WA.Managers.ajax.Request(url,method,data,feedback,dosend,self.listener,self.statefeedback,self.timeoutabort);if(r)
{self.requests.push(r);r.setPeriodic(period,times);}
return r;}
this.destroyRequest=destroyRequest;function destroyRequest(r)
{for(var i=0,l=self.requests.length;i<l;i++)
{if(self.requests[i]==r)
{self.requests[i].destroy();self.requests.splice(i,1);callNotify('destroy');break;}}}
function destroy()
{for(var i=0,l=self.requests.length;i<l;i++)
self.requests[i].destroy();self.listener=null;delete self.requests;self=null;}
WA.Managers.event.registerFlush(destroy);}();WA.Managers.ajax.Request=function(url,method,data,feedback,autosend,listener,statefeedback,timeoutabort)
{var self=this;this.url=url;this.method=method.toUpperCase();this.data=data;this.feedback=feedback;this.autosend=autosend;this.period=0;this.times=0;this.statefeedback=statefeedback;this.timeoutabort=timeoutabort;this.request=null;this.parameters=null;this.putdata=null;this.timer=null;this.timerabort=null;this.state=0;this.listener=listener;try{this.request=new XMLHttpRequest();}
catch(e)
{try{this.request=new ActiveXObject('Msxml2.XMLHTTP.3.0');}
catch(e)
{try{this.request=new ActiveXObject('Msxml2.XMLHTTP');}
catch(e)
{try{this.request=new ActiveXObject('Microsoft.XMLHTTP');}
catch(e)
{alert(WA.i18n.getMessage('ajax.notsupported'));}}}}
function callNotify(event,data)
{if(self.listener)
{self.listener(event,data);}}
this.setPeriodic=setPeriodic;function setPeriodic(period,times)
{self.period=period;self.times=times;}
this.addStateFeedback=addStateFeedback;function addStateFeedback(statefeedback,timeoutabort)
{self.statefeedback=statefeedback;if(timeoutabort!=undefined&&timeoutabort!=null)
self.timeoutabort=timeoutabort;}
this.setTimeoutAbort=setTimeoutAbort;function setTimeoutAbort(timeoutabort)
{self.timeoutabort=timeoutabort;}
this.addParameter=addParameter;function addParameter(id,value)
{if(self.parameters===null)
self.parameters={};self.parameters[id]=value;}
this.addPutData=addPutData;function addPutData(data)
{self.putdata=data;}
this.getParameters=getParameters;function getParameters()
{return self.parameters;}
this.clearParameters=clearParameters;function clearParameters()
{self.parameters=null;}
function buildParametersPost()
{var data=self.data||'';for(i in self.parameters)
data+=(data.length>0?'&':'')+encodeURIComponent(i)+'='+encodeURIComponent(self.parameters[i]);return data;}
function buildParameters()
{var data=self.data||'';for(i in self.parameters)
data+=(data.length>0?'&':'')+escape(i)+'='+escape(self.parameters[i]);return data;}
function headers()
{self.request.setRequestHeader('X-Requested-With','WAJAF::Ajax - WebAbility(r) v5');if(self.method=='POST'||self.method=='PUT')
{self.request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}}
this.send=send;function send()
{if(self.timer)
self.timer=null;if(self.request.readyState!=0&&self.request.readyState!=4)
return;self.request.onreadystatechange=process;if(self.timeoutabort)
self.timerabort=setTimeout(function(){timeabort();},self.timeoutabort);try
{var url=self.url;if(self.method=='GET')
{var parameters=buildParameters();if(parameters.length>0)
url+=(url.match(/\?/)?'&':'?')+parameters;}
self.request.open(self.method,url,true);self.request.withCredentials=true;headers();callNotify('start');if(self.method=='POST')
{var parameters=buildParametersPost();self.request.send(parameters);}
else if(self.method=='PUT')
{if(self.putdata)
self.request.send(self.putdata);else
self.request.send(WA.JSON.encode(self.parameters));}
else
self.request.send(null);self.state=1;}
catch(e)
{self.state=3;processError(1,e);}}
function process()
{try
{if(self.request.readyState==4)
{if(self.request.status==200)
{if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
callNotify('stop');if(self.feedback)
{self.feedback(self.request);}
self.state=2;}
else
{self.state=3;processError(3,WA.i18n.getMessage('ajax.error')+self.request.status+':\n'+self.request.statusText,self.request);}
self.request.onreadystatechange=WA.nothing;var state=checkPeriod();if(!state)
setTimeout(function(){WA.Managers.ajax.destroyRequest(self);},1);}
else
{waiting();}}
catch(e)
{self.state=3;processError(2,e);}}
function checkPeriod()
{if(self.period)
{if(--self.times>0)
{self.timer=setTimeout(function(){self.send();},self.period);return true;}}
return false;}
function waiting()
{if(self.statefeedback)
self.statefeedback('wait',self.request.readyState,'');}
function processError(type,error,request)
{console.log('ERROR:');console.log(type);console.log(error);console.log(request);callNotify('error',type);if(typeof error=='object')
error=error.message;if(self.statefeedback)
self.statefeedback('error',type,error,request);}
function doabort()
{if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
self.request.abort();self.request.onreadystatechange=WA.nothing;if(!checkPeriod())
setTimeout(function(){WA.Managers.ajax.destroyRequest(self);},1);}
function timeabort()
{self.timerabort=null;callNotify('abortbytimeout');doabort();}
this.abort=abort;function abort()
{if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
callNotify('abortbyuser');doabort();}
this.destroy=destroy;function destroy()
{self.period=0;self.times=0;if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
if(self.state==1||self.state==3)
{doabort();}
self.request.onreadystatechange=WA.nothing;self.clearParameters();delete self.request;self.statefeedback=null;self.feedback=null;self=null;}
if(autosend)
this.send();}
WA.i18n.setEntry('ajax.notsupported','XMLHttpRequest is not supported. AJAX will not be available.');WA.i18n.setEntry('ajax.send','Sending AJAX request to: ');WA.i18n.setEntry('ajax.errorcreation','Error creating AJAX request to: ');WA.i18n.setEntry('ajax.received','AJAX answer received from: ');WA.i18n.setEntry('ajax.errorreception','Error during AJAX reception from: ');WA.i18n.setEntry('ajax.fatalerror','Fatal error during AJAX reception from: ');WA.i18n.setEntry('ajax.error','Error: ');WA.Managers.ajax.PromiseRequest=function(data,listener,timeoutabort)
{var self=this;this.url=data.url;this.method=data.method.toUpperCase();this.data=data.data;this.feedback=data.feedback;this.autosend=data.send;this.period=0;this.times=0;this.statefeedback=listener;this.timeoutabort=timeoutabort;this.request=null;this.parameters=null;this.timer=null;this.timerabort=null;this.state=0;this.listener=listener;this.onuploadprogress=null;this.onloadstart=null;this.onloadend=null;try{this.request=new XMLHttpRequest();}
catch(e)
{try{this.request=new ActiveXObject('Msxml2.XMLHTTP.3.0');}
catch(e)
{try{this.request=new ActiveXObject('Msxml2.XMLHTTP');}
catch(e)
{try{this.request=new ActiveXObject('Microsoft.XMLHTTP');}
catch(e)
{alert(WA.i18n.getMessage('ajax.notsupported'));}}}}
function callNotify(event,data)
{if(self.listener)
{self.listener(event,data);}}
this.setPeriodic=setPeriodic;function setPeriodic(period,times)
{self.period=period;self.times=times;}
this.addStateFeedback=addStateFeedback;function addStateFeedback(statefeedback,timeoutabort)
{self.statefeedback=statefeedback;if(timeoutabort!=undefined&&timeoutabort!=null)
self.timeoutabort=timeoutabort;}
this.setTimeoutAbort=setTimeoutAbort;function setTimeoutAbort(timeoutabort)
{self.timeoutabort=timeoutabort;}
this.addParameter=addParameter;function addParameter(id,value)
{if(self.parameters===null)
self.parameters={};self.parameters[id]=value;}
this.getParameters=getParameters;function getParameters()
{return self.parameters;}
this.clearParameters=clearParameters;function clearParameters()
{self.parameters=null;}
function buildParametersPost()
{var data=self.data||'';for(i in self.parameters)
data+=(data.length>0?'&':'')+encodeURIComponent(i)+'='+encodeURIComponent(self.parameters[i]);return data;}
function buildParameters()
{var data=self.data||'';for(i in self.parameters)
data+=(data.length>0?'&':'')+escape(i)+'='+escape(self.parameters[i]);return data;}
function headers()
{self.request.setRequestHeader('X-Requested-With','WAJAF::Ajax - WebAbility(r) v5');if(self.method=='POST'||self.method=='PUT')
{self.request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');}}
this.send=send;function send(form)
{prom=new Promise(function(resolve,reject){if(self.timer)
self.timer=null;if(self.request.readyState!=0&&self.request.readyState!=4)
{reject(1,"NO READY STATE, STILL DOING SOMETHING");return;}
self.request.onreadystatechange=process;if(self.timeoutabort)
self.timerabort=setTimeout(function(){timeabort();},self.timeoutabort);try
{var url=self.url;if(self.method=='GET')
{var parameters=buildParameters();if(parameters.length>0)
url+=(url.match(/\?/)?'&':'?')+parameters;}
self.request.open(self.method,url,true);self.request.withCredentials=true;self.request.onloadstart=((self.onloadstart&&(typeof(self.onloadstart)==='function'))?self.onloadstart:null);var onuploadprogress=((self.onuploadprogress&&(typeof(self.onuploadprogress)==='function'))?self.onuploadprogress:null);self.request.upload.addEventListener('progress',onuploadprogress);self.request.onloadend=((self.onloadend&&(typeof(self.onloadend)==='function'))?self.onloadend:null);if(!form)
headers();callNotify('start');if(self.method=='POST')
{if(!!form)
self.request.send(form);else
{var parameters=buildParametersPost();self.request.send(parameters);}}
else if(self.method=='PUT')
self.request.send(WA.JSON.encode(self.parameters));else
self.request.send(null);self.state=1;}
catch(e)
{self.state=3;reject2(0,e);}
function process()
{try
{if(self.request.readyState==4)
{if(self.request.status==200)
{if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
callNotify('stop');resolve(self.request.responseText);self.state=2;}
else
{self.state=3;reject(self.request.status,self.request.statusText);}
self.request.onreadystatechange=WA.nothing;var state=checkPeriod();if(!state)
setTimeout(function(){WA.Managers.ajax.destroyRequest(self);},1);}
else
{waiting();}}
catch(e)
{self.state=3;reject2(0,e);}}});return prom;}
function checkPeriod()
{if(self.period)
{if(--self.times>0)
{self.timer=setTimeout(function(){self.send();},self.period);return true;}}
return false;}
function waiting()
{if(self.statefeedback)
self.statefeedback('wait',self.request.readyState,'');}
function doabort()
{if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
self.request.abort();self.request.onreadystatechange=WA.nothing;if(!checkPeriod())
setTimeout(function(){WA.Managers.ajax.destroyRequest(self);},1);}
function timeabort()
{self.timerabort=null;callNotify('abortbytimeout');doabort();}
this.abort=abort;function abort()
{if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
callNotify('abortbyuser');doabort();}
this.destroy=destroy;function destroy()
{self.period=0;self.times=0;if(self.timerabort)
{clearTimeout(self.timerabort);self.timerabort=null;}
if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
if(self.state==1||self.state==3)
{doabort();}
self.request.onreadystatechange=WA.nothing;self.clearParameters();delete self.request;self.statefeedback=null;self.feedback=null;self=null;}
if(self.autosend)
this.send();return this;}
WA.Managers.anim=new function()
{var self=this;var counter=1;this.sprites={};this.animator={};this.createSprite=createSprite;function createSprite(id,domNode,callback,script)
{if(!id)
id='sprite'+(counter++);if(self.sprites[id])
return self.sprites[id];WA.debug.explain('animManager.createSprite('+id+')');var sp=new WA.Managers.anim.Sprite(id,domNode,callback,script);self.sprites[id]=sp;return sp;}
this.createAnimator=createAnimator;function createAnimator(id,domNode,image,positions,animations,sounds,callback)
{if(!id)
id='animator'+(counter++);if(self.animator[id])
return self.animator[id];WA.debug.explain('animManager.createAnimator('+id+')');var an=new WA.Managers.anim.Animator(id,domNode,image,positions,animations,sounds,callback);self.animator[id]=an;return an;}
this.destroyAnimator=destroyAnimator;function destroyAnimator(id)
{}
this.fadein=this.fadeIn=fadein;function fadein(domNode,time,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',tinit:0,tend:100,time:time}]});}
this.fadeout=this.fadeOut=fadeout;function fadeout(domNode,time,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',tinit:100,tend:0,time:time}]});}
this.openV=openV;function openV(domNode,time,hend,callback)
{if(!hend)
{var d=WA.createDomNode('div','','');d.style.height='1px';d.style.width='1px';d.style.overflow='hidden';domNode.parentNode.insertBefore(d,domNode);d.appendChild(domNode);domNode.style.height='';hend=WA.browser.getNodeHeight(domNode);d.parentNode.insertBefore(domNode,d);d.parentNode.removeChild(d);}
self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',hinit:WA.browser.isMSIE?1:0,hend:hend,time:time}]});}
this.closeV=closeV;function closeV(domNode,time,hinit,callback)
{if(!hinit)
{hinit=WA.browser.getNodeHeight(domNode);}
self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',hinit:hinit,hend:WA.browser.isMSIE?1:0,time:time}]});}
this.openH=openH;function openH(domNode,time,wend,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',winit:WA.browser.isMSIE?1:0,wend:wend,time:time}]});}
this.closeH=closeH;function closeH(domNode,time,winit,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',winit:winit,wend:WA.browser.isMSIE?1:0,time:time}]});}
this.open=open;function open(domNode,time,wend,hend,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',winit:WA.browser.isMSIE?1:0,wend:wend,hinit:WA.browser.isMSIE?1:0,hend:hend,time:time}]});}
this.close=close;function close(domNode,time,winit,hinit,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',winit:winit,wend:WA.browser.isMSIE?1:0,hinit:hinit,hend:WA.browser.isMSIE?1:0,time:time}]});}
this.move=move;function move(domNode,time,xinit,yinit,xend,yend,callback)
{self.createSprite(domNode.id,domNode,callback,{autostart:true,loop:false,chain:[{type:'move',xinit:xinit,xend:xend,yinit:yinit,yend:yend,time:time}]});}
this.destroySprite=destroySprite;function destroySprite(id)
{if(self.sprites[id])
{WA.debug.explain('animManager.destroySprite('+id+')');self.sprites[id].destroy();delete self.sprites[id];}}
function destroy()
{for(var i in self.sprites)
{self.sprites[i].destroy();delete self.sprites[i];}
delete self.sprites;self=null;}
WA.Managers.event.registerFlush(destroy);}();WA.Managers.anim.Sprite=function(id,domNode,callback,script)
{var self=this;this.domNode=WA.toDOM(domNode);if(this.domNode==null)
return;this.id=id;this.callback=callback;this.script=script;this.timer=null;this.starttime=null;this.pointer=0;this.suspendedtime=0;this.suspended=false;function _getHex(v)
{if(v<0)v=0;if(v>255)v=255;var s=v.toString(16).toUpperCase();if(s.length<2)
s='0'+s;return s;}
this.start=start;function start()
{self.starttime=new Date().getTime();self.pointer=0;if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
_anim();}
this.suspend=suspend;function suspend()
{if(self.timer&&!self.suspended)
{self.suspendedtime=new Date().getTime();self.suspended=true;clearTimeout(self.timer);self.timer=null;}}
this.resume=resume;function resume()
{if(self.suspended)
{var delta=new Date().getTime()-self.suspendedtime;self.starttime+=delta;self.suspended=false;_anim();}}
this.stop=stop;function stop()
{if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
setTimeout(function(){animManager.destroySprite(self.id);},1);}
function _anim()
{clearTimeout(self.timer);self.timer=null;var time=new Date().getTime();var diff=time-self.starttime;var order=self.script.chain[self.pointer];if(order.calculate)
order=order.calculate(diff,order);if(diff>order.time)
{if(order.type=='move')
{if(order.xend!=undefined)
self.domNode.style.left=order.xend+'px';if(order.yend!=undefined)
self.domNode.style.top=order.yend+'px';if(order.wend!=undefined)
self.domNode.style.width=order.wend+'px';if(order.hend!=undefined)
self.domNode.style.height=order.hend+'px';if(order.rend!=undefined)
self.domNode.style.color='#'+_getHex(order.rend)+_getHex(order.gend)+_getHex(order.bend);if(order.brend!=undefined)
self.domNode.style.backgroundColor='#'+_getHex(order.brend)+_getHex(order.bgend)+_getHex(order.bbend);if(order.tend!=undefined)
{self.domNode.style.opacity=order.tend/100;self.domNode.style.filter='alpha(opacity: '+order.tend+')';}}
self.pointer++;if(!self.script.chain[self.pointer])
{if(!self.script.loop)
{if(self.callback)
self.callback('end');WA.Managers.anim.destroySprite(self.id);return;}
self.pointer=0;if(self.callback)
self.callback('loop');}
self.starttime=new Date().getTime()-diff+order.time;self.timer=setTimeout(_anim,10);}
else
{if(order.type=='wait')
{self.timer=setTimeout(_anim,order.time-diff);return;}
if(order.xend!=undefined)
{if(order.xinit===undefined||order.xinit===null)
order.xinit=WA.browser.getNodeNodeLeft(self.domNode);var x=order.xinit+Math.ceil((order.xend-order.xinit)/order.time*diff);self.domNode.style.left=x+'px';}
if(order.yend!=undefined)
{if(order.yinit===undefined||order.yinit===null)
order.yinit=WA.browser.getNodeTop(self.domNode);var y=order.yinit+Math.ceil((order.yend-order.yinit)/order.time*diff);self.domNode.style.top=y+'px';}
if(order.wend!=undefined)
{if(order.winit===undefined||order.winit===null)
order.winit=WA.browser.getNodeWidth(self.domNode);var w=order.winit+Math.ceil((order.wend-order.winit)/order.time*diff);self.domNode.style.width=w+'px';}
if(order.hend!=undefined)
{if(order.hinit===undefined||order.hinit===null)
order.hinit=WA.browser.getNodeHeight(self.domNode);var h=order.hinit+Math.ceil((order.hend-order.hinit)/order.time*diff);self.domNode.style.height=h+'px';}
if(order.rend!=undefined||order.gend!=undefined||order.bend!=undefined)
{if(!order.rinit||!order.ginit||!order.binit)
{order.xinit=WA.browser.getNodeNodeLeft(self.domNode);}
var r=order.rinit+Math.ceil((order.rend-order.rinit)/order.time*diff);var g=order.ginit+Math.ceil((order.gend-order.ginit)/order.time*diff);var b=order.binit+Math.ceil((order.bend-order.binit)/order.time*diff);self.domNode.style.color='#'+_getHex(r)+_getHex(g)+_getHex(b);}
if(order.brend!=undefined||order.bgend!=undefined||order.bbend!=undefined)
{if(!order.rinit||!order.ginit||!order.binit)
{order.xinit=WA.browser.getNodeNodeLeft(self.domNode);}
var br=order.brinit+Math.ceil((order.brend-order.brinit)/order.time*diff);var bg=order.bginit+Math.ceil((order.bgend-order.bginit)/order.time*diff);var bb=order.bbinit+Math.ceil((order.bbend-order.bbinit)/order.time*diff);self.domNode.style.backgroundColor='#'+_getHex(br)+_getHex(bg)+_getHex(bb);}
if(order.tend!=undefined)
{if(!order.tinit)
{order.xinit=WA.browser.getNodeNodeLeft(self.domNode);}
var t=order.tinit+Math.ceil((order.tend-order.tinit)/order.time*diff);self.domNode.style.opacity=t/100;self.domNode.style.filter='alpha(opacity: '+t+')';}
self.timer=setTimeout(_anim,10);}}
this.destroy=destroy;function destroy()
{if(self.timer)
clearTimeout(self.timer);self.timer=null;self.starttime=null;self.pointer=0;self.id=null;self.callback=null;self.script=null;self.domNode=null;self=null;}
if(script.autostart)
this.start();return this;}
WA.Managers.anim.Animator=function(id,domNode,image,positions,animations,sounds,callback)
{var self=this;this.sound=!!WA.Managers.sound;this.domNode=WA.toDOM(domNode);if(this.domNode==null)
return;this.id=id;this.image=image;this.positions=positions;this.animations=animations;this.sounds=sounds;this.callback=callback;for(var i in animations)
{this.defanim=i;break;}
if(this.sound)
{for(var i in sounds)
{WA.Managers.sound.addSound('animator_'+id+'_'+i,sounds[i]);}}
this.anim=this.defanim;this.frame=0;this.factor=1;this.timer=null;this.starttime=null;function setImage()
{self.domNode.style.backgroundPosition=-self.positions[self.animations[self.anim][self.frame].f].x+'px '+
-self.positions[self.animations[self.anim][self.frame].f].y+'px';self.domNode.style.width=self.positions[self.animations[self.anim][self.frame].f].w+'px';self.domNode.style.height=self.positions[self.animations[self.anim][self.frame].f].h+'px';if(self.animations[self.anim][self.frame].m&&self.sound)
{WA.Managers.sound.startSound('animator_'+self.id+'_'+self.animations[self.anim][self.frame].m);}
if(self.callback)
self.callback(self.id,'frame',self.anim,self.frame);}
this.setdefault=setdefault;function setdefault(id)
{if(self.defanim==self.anim)
{self.anim=id;self.frame=0;self.factor=1;setImage();}
self.defanim=id;self.defframe=0;}
this.start=start;function start()
{self.starttime=new Date().getTime();self.frame=0;self.factor=1;if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
setImage();_anim();}
this.startanim=startanim;function startanim(entry,factor,loop,synchro)
{self.starttime=new Date().getTime();if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
self.anim=entry;self.frame=0;self.factor=factor;setImage();_anim();}
this.stopanim=stopanim;function stopanim(restart)
{self.starttime=new Date().getTime();if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
self.anim=self.defanim;self.frame=0;self.factor=1;setImage();_anim();}
this.stop=stop;function stop()
{if(self.timer)
{clearTimeout(self.timer);self.timer=null;}}
function _anim()
{if(self.timer)
{clearTimeout(self.timer);self.timer=null;}
var time=new Date().getTime();var diff=time-self.starttime;if(diff>self.animations[self.anim][self.frame].t/self.factor)
{self.starttime+=self.animations[self.anim][self.frame].t/self.factor;if(++self.frame>=self.animations[self.anim].length)
self.frame=0;setImage();}
self.timer=setTimeout(_anim,10);}
this.destroy=destroy;function destroy()
{if(self.timer)
clearTimeout(self.timer);self.timer=null;self.starttime=null;self.pointer=0;self.id=null;self.callback=null;self.script=null;self.domNode=null;self=null;}
this.domNode.style.backgroundImage='url('+this.image+')';this.domNode.style.backgroundRepeat='no-repeat';start();}
WA.Managers.queue=new function()
{var self=this;this.queues={};this.create=create;function create(id)
{self.queues[id]=new WA.Managers.queue.queue(id);return self.queues[id];}
function destroy()
{delete self.queues;self=null;}
WA.Managers.event.registerFlush(destroy);}();WA.Managers.queue.queue=function(id)
{var self=this;this.queue=[];this.add=add;function add(fct)
{self.queue.push(fct);}
this.del=del;function del(fct)
{}
this.clear=clear;function clear()
{self.queue=[];}
this.call=call;function call()
{for(var i=0,l=self.queue.length;i<l;i++)
self.queue[i].apply(this,arguments);}
function destroy()
{delete self.queue;self=null;}}
var validator={version:'1.0.0'}
validator.base=function(listener)
{var self=this;this.status=false;this.blurred=false;this.listener=listener;}
validator.textfield=function(id,params,checkimage,listener)
{var self=this;validator.textfield.sourceconstructor.call(this,listener);this.Node=WA.toDOM(id);this.NodeCheckImage=WA.toDOM(checkimage);this.id=this.Node.id;this.checks={minlength:params.minlength?params.minlength:null,maxlength:params.maxlength?params.maxlength:null,minwords:params.minwords?params.minwords:null,maxwords:params.maxwords?params.maxwords:null,notempty:params.notempty?params.notempty:null,format:params.format?new RegExp(params.format):null,extra:params.checkextra?params.checkextra:null};this.errors={minlength:false,maxlength:false,minwords:false,maxwords:false,notempty:false,format:false,extra:false};this.errormessages={minlength:'Error: tiene que capturar m�nimo '+this.minlength+' car�cteres',maxlength:'Error: tiene que capturar m�ximo '+this.maxlength+' car�cteres',minwords:'Error: tiene que capturar m�nimo '+this.minwords+' palabras',maxwords:'Error: tiene que capturar m�nimo '+this.maxwords+' palabras',notempty:'Error: tiene que capturar m�nimo 1 caracter',format:'Error: el campo no tiene un formato v�lido',extra:'Error: verifique el valor del campo'};WA.Managers.event.on('focus',this.Node,focus,true);WA.Managers.event.on('blur',this.Node,blur,true);WA.Managers.event.on('keyup',this.Node,keyup,true);WA.Managers.event.on('paste',this.Node,keyup,true);WA.Managers.event.on('change',this.Node,keyup,true);function focus(e)
{var n=WA.toDOM(self.id+'_tooltip');if(n)
n.style.display='';}
function blur(e)
{var n=WA.toDOM(self.id+'_tooltip');if(n)
n.style.display='none';self.blurred=true;}
function keyup(e)
{var t=setTimeout(validar,0);}
this.validar=validar;function validar()
{for(var i in self.errors)
self.errors[i]=false;var value=self.Node.value;self.status=true;if(self.checks.notempty&&value=='')
{self.status=false;self.errors.notempty=true;}
if(self.checks.minlength&&value.length<self.checks.minlength)
{self.status=false;self.errors.minlength=true;}
if(self.checks.maxlength&&value.length>self.checks.maxlength)
{self.status=false;self.errors.maxlength=true;}
if(self.checks.maxwords||self.checks.minwords)
{var text=value;text=text.replace(/^[ ]+/,"");text=text.replace(/[ ]+$/,"");text=text.replace(/[ ]+/g," ");text=text.replace(/[\n]+/g," ");var numpalabras=(text.length>0?text.split(" ").length:0);if(numpalabras<self.checks.minwords)
{self.status=false;self.errors.minwords=true;}
if(numpalabras>self.checks.maxwords)
{self.status=false;self.errors.maxwords=true;}}
if(self.checks.format&&value.match(self.checks.format)==null)
{self.status=false;self.errors.format=true;}
if(self.checks.extra)
{var result=self.checks.extra(value);if(result)
{self.status=false;self.errors.extra=true;}}
self.NodeCheckImage.style.display=self.status?'':'none';if(self.listener)
self.listener(self);}
this.forceerror=forceerror;function forceerror()
{self.status=false;self.errors.extra=true;self.NodeCheckImage.style.display=self.status?'':'none';if(self.listener)
self.listener(self);}
validar();}
WA.extend(validator.textfield,validator.base);validator.checkboxfield=function(id,params,checkimage,listener)
{var self=this;validator.checkboxfield.sourceconstructor.call(this,listener);this.Node=WA.toDOM(id);this.NodeCheckImage=WA.toDOM(checkimage);this.id=this.Node.id;this.checks={notempty:params.notempty?params.notempty:null,extra:params.checkextra?params.checkextra:null};this.errors={notempty:false,extra:false};this.errormessages={notempty:'Error: tiene que poner una palemita en este campo',extra:'Error: verifique el valor del campo'};WA.Managers.event.on('focus',this.Node,focus,true);WA.Managers.event.on('blur',this.Node,blur,true);WA.Managers.event.on('mouseover',this.Node,focus,true);WA.Managers.event.on('mouseout',this.Node,blur,true);WA.Managers.event.on('click',this.Node,keyup,true);WA.Managers.event.on('change',this.Node,keyup,true);function focus(e)
{var n=WA.toDOM(self.id+'_tooltip');if(n)
n.style.display='';}
function blur(e)
{var n=WA.toDOM(self.id+'_tooltip');if(n)
n.style.display='none';}
function keyup(e)
{var t=setTimeout(validar,0);}
function validar()
{for(var i in self.errors)
self.errors[i]=false;var checked=self.Node.checked;self.status=true;if(self.checks.notempty&&!checked)
{self.status=false;self.errors.notempty=true;}
if(self.checks.extra)
{var result=self.checks.extra(checked);if(result)
{self.status=false;self.errors.extra=true;}}
if(self.listener)
self.listener(self);}
validar();}
WA.extend(validator.checkboxfield,validator.base);function ajaximage(formid,nodeid)
{var self=this;this.formid=formid;this.form=WA.toDOM(formid);this.nodeid=nodeid;this.downloadnode=WA.toDOM(nodeid+'_download');this.imagenode=WA.toDOM(nodeid+'_image');this.filenode=WA.toDOM(nodeid+'_file');this.loading=false;this.loadingimage='/images/loading.gif';this.action='/doeditor?orden=foto';this.page=null;this.container=null;this.check=null;this.setLoadingImage=setLoadingImage;function setLoadingImage(img)
{self.loadingimage=img;}
this.setAction=setAction;function setAction(action)
{self.action=action;}
this.setPage=setPage;function setPage(page)
{self.page=page;}
this.changeImage=changeImage;function changeImage()
{var oldtarget=self.form.target;var oldaction=self.form.action;var oldpage=null;if(self.form.elements["orden"]&&self.page)
{oldpage=self.form.elements["orden"].value;self.form.elements["orden"].value=self.page;}
self.form.action=self.action;self.form.target=self.nodeid+'_hiddeniframe';self.loading=true;if(self.check)
self.check('change');if(WA.toDOM("barratiempo_subeimg"))
self.imagenode.style.display='none';self.imagenode.src=self.loadingimage;var imageFile=(self.downloadnode.files.length>0?self.downloadnode.files[0]:false);if(!imageFile)
{alert('No image file');return;}
var auxForm=new FormData();auxForm.append(self.nodeid+'_download',imageFile);WA.Managers.ajax.createPromiseRequest({url:self.form.action,method:'POST',send:false}).then(function(request){request.onloadstart=()=>{showProgressBar();};request.onuploadprogress=function(e){if(e.lengthComputable)
{var progress=Math.round((e.loaded/e.total)*100);setProgressToProgresBar(progress);}};return request.send(auxForm);}).then(function(response){processResponseScript(response);}).catch(function(code,err){hideProgressBar();try
{alerta(WA.i18n.getMessage("errorcargaimagen"));}catch(e)
{alert("Ocurri� un error al subir la foto");}})
self.form.target=oldtarget;self.form.action=oldaction;if(oldpage)
self.form.elements["orden"].value=oldpage;}
function setProgressToProgresBar(progress)
{if(isNaN(progress))
return;progress=parseInt(progress);if(progress<0)
progress=0;if(progress>100)
progress=100;var progressNode=WA.toDOM("barratiempo_indiceimg");if(progressNode)
progressNode.style.width=progress+'%';}
function showProgressBar()
{var progressBarNode=WA.toDOM("barratiempo_subeimg");if(progressBarNode&&(progressBarNode.style.display==='none'))
{setProgressToProgresBar(0);progressBarNode.style.display='block';}}
function hideProgressBar()
{var progressBarNode=WA.toDOM("barratiempo_subeimg");if(progressBarNode&&(progressBarNode.style.display==='block'))
progressBarNode.style.display='none';}
function processResponseScript(response)
{try
{var auxdiv=document.createElement('div');auxdiv.innerHTML=response.trim();var script=auxdiv.getElementsByTagName('script')[0];eval(script.innerHTML);}
catch(e)
{console.error('Error: Image upload response unprocessable\n',e,'\nResponse:\n',response);}}
this.setImage=setImage;function setImage(path,name)
{self.imagenode.src=path+name;self.filenode.value=name;self.loading=false;if(self.check)
self.check('set');}
this.setCheck=setCheck;function setCheck(check)
{self.check=check;}
this.downloadnode.onchange=this.changeImage;return this;}
KL.language='es';KL.locale='es_LA';var translation={"txtverificabuscadatos1":"Sin","txtverificabuscadatos2":"en","txtverificabuscadatos3":"ms","txtgetseleccionacoleccion1":"Colecciones","txtgetseleccionacoleccion2":"Se ha agregado este tip a tu colección","txtgetseleccionacoleccion3":"Se ha agregado esta receta a tu colección","txtgetcrearcoleccion1":"Colección creada y tip agregado exitosamente","txtgetcrearcoleccion2":"Colección creada y receta agregada exitosamente","txtgetagregarfav1":"Favoritos","txtgetagregarfav2":"Se ha agregado este tip a tus favoritos.","txtgetagregarfav3":"Se ha agregado esta receta a tus favoritos.","txtvalidaliga":"No capturaste una liga correcta.","txtrellenarfotos":"Foto","txtpasoImg1":"No hay suficientes imágenes insertadas aun.","txtpasoImg2":"Ya haz utilizado todas tus imágenes subidas.","txtinforestantes1":"Nombre de la receta.","txtinforestantes2":"Descripción de la receta.","txtinforestantes3":"Porciones.","txtinforestantes4":"Tiempo de preparación.","txtinforestantes5":"Ingredientes.","txtinforestantes6":"Pasos.","txtinforestantes7":"Campos faltantes o incompletos de tu receta","txtcharcount":"Cantidad de letras","txtsendnewsletter":"Error, no capturaste ningún correo electrónico.","txtgetnewsletter":"Gracias por registrarte al newsletter de Kiwilimón.","txtgetTime1":"Tiempo agotado","txtgetTime2":"seg","txtgetTime3":"día","txtgetTime4":"d&iacute;as","txtsiguientemensaje":"Mensaje de kiwilimon","txtfillMenuInfo1":"Ver todas las categorías","txtrecibirsugerencia1":"No hay Sugerencias","txtborrarcoleccion":"¿Estas seguro que quieres borrar esta colección?","txtherramientas1":"Confirmar","txtherramientas2":"Cancelar","txtborrarChefSiguiendo":"¿Estas seguro que quieres dejar de seguir este chef?","txtgetborrarcoleccion":"La colección fue borrada con éxito","txtborrarobjetocoleccion":"¿Estas seguro que quieres borrar este elemento?","txtgetmodificarcoleccion":"Se ha modificado con éxito","txtgetseleccionalistasuper1":"Lista del Super","txtgetseleccionalistasuper2":"Se ha agregado esta receta a tu lista del super.","txtmuestralista":"Imprimir","txtmuestralista1":"Enviar","txtEliminalistas":"¿Estas seguro que quieres borrar esta lista del súper?","txtEliminalistasrespuesta":"La lista fue eliminada","txtEnviarMailLista":"Seleccione mínimo un ingrediente para envair el correo","txtcorreoenviado":"Se ha enviado tu lista del super.","txtgetmodificarlista":"Se ha modificado con éxito","txteliminarreceta":"¿Estas seguro que quieres borrar esta receta de tu lista del súper?","txtdoeliminareceta1":"No existen recetas para esta lista","txtdoeliminareceta2":"Aún no tienes recetas en la Lista del Súper","txteliminaingrediente":"¿Estas seguro que quieres borrar este ingrediente de tu lista del súper?","txteliminaextra":"¿Estas seguro que quieres borrar este ingrediente de tu lista del súper?","txtextraeliminado":"El ingrediente fue eliminado con éxito","txtingredienterecuperado":"El ingrediente fue recuperado con éxito","loaderdia1":"Domingo","loaderdia2":"Lunes","loaderdia3":"Martes","loaderdia4":"Miércoles","loaderdia5":"Jueves","loaderdia6":"Viernes","loaderdia7":"Sábado","loaderdiamin1":"Dom","loaderdiamin2":"Lun","loaderdiamin3":"Mar","loaderdiamin4":"Mie","loaderdiamin5":"Jue","loaderdiamin6":"Vie","loaderdiamin7":"Sab","loadermes1":"Enero","loadermes2":"Febrero","loadermes3":"Marzo","loadermes4":"Abril","loadermes5":"Mayo","loadermes6":"Junio","loadermes7":"Julio","loadermes8":"Agosto","loadermes9":"Septiembre","loadermes10":"Octubre","loadermes11":"Noviembre","loadermes12":"Diciembre","loadermesmin1":"Ene","loadermesmin2":"Feb","loadermesmin3":"Mar","loadermesmin4":"Abr","loadermesmin5":"May","loadermesmin6":"Jun","loadermesmin7":"Jul","loadermesmin8":"Ago","loadermesmin9":"Sep","loadermesmin10":"Oct","loadermesmin11":"Nov","loadermesmin12":"Dic","txtfilldatossocial1":"'Red social: Facebook'","txtfilldatossocial2":"Red social: Google","txtfilldatossocial3":"Conexión con tu teléfono","txtfilldatossocial4":"Nativo","txtfilldatossocial5":"Sexo:","txtfilldatossocial6":"Hombre","txtfilldatossocial7":"Mujer","txtfilldatossocial8":"Fecha de nacimiento","txtfilldatossocial9":"Número","txtnotif1":"Hace : unos momentos","txtnotif2":"Hace","txtnotif3":"minuto","txtnotif4":"minutos","txtnotif5":"hora","txtnotif6":"horas","txtnotif7":"día","txtnotif8":"días","txtnotif9":"mes","txtnotif10":"meses","txtnotif11":"año","txtnotif12":"años","txtplaneador1":"Fácil","txtplaneador2":"Medio","txtplaneador3":"Dificil","txtplaneador4":"de","txtplaneador5":"Planeador de Menú","txtplaneador6":"Ver más Recetas","txtplaneador7":"Regresar","txtplaneadortipo1":"desayuno","txtplaneadortipo2":"comida","txtplaneadortipo3":"cena","txtplaneadortipo4":"snack","txtplaneadortipo5":"ninguno","txtplaneador8":"La receta se agregó con éxito <br>¿Ir al Calendario?","txtplaneador9":"SI","txtplaneador10":"NO","txtplaneador11":"Hace falta la receta","txtplaneador12":"Seleccione un día","txtplaneador13":"Seleccione un el tipo de comida","txtplaneador14":"Mover receta","txtplaneador15":"a contenedor","txtplaneador16":"No hay Sugerencias","txtplaneador17":"Debes escribir el nombre de algun ingrediente","txtplaneador18":"Ya seleccionaste este Ingrediente","txtplaneador19":"Selecciona al menos un día y un tiempo para guardar tu Menú","txtplaneador20":"Trabajando...","txtplaneador21":"El menu se guardo con éxito","txtplaneador22":"¿Ir al Calendario?","txtpventa1":"Procesando... favor de esperar...","txtpventa2":"Realizar Pago","txtpventa3":"Error desconocido. Favor de intentar de nuevo. Puede recargar la página si el error persiste.","txtpventa4":"Ingresa el número de tu tarjeta.","txtpventa5":"Elige un mes.","txtpventa6":"Elige un año.","txtpventa7":"Ingresa el nombre y apellido.","txtpventa8":"Ingresa el código de seguridad.","txtpventa9":"Hay algo mal con el número de la tarjeta. Vuelve a ingresarlo.","txtpventa10":"Revisa el código de seguridad.","txtpventa11":"Ingresa un nombre valido.","txtpventa12":"Revisa el mes de la fecha.","txtpventa13":"Revisa el año de la fecha","txtpventa14":"Hay algún error desconocido en tus datos, favor de revisarlos.","txtpventa15":"Captura tu nombre","txtpventa16":"De 2 a 50 caracteres, máximo 5 palabras y únicamente letras","txtpventa17":"Captura tu correo electrónico","txtpventa18":"El correo no tiene un formato válido","txtpventa19":"Captura la calle","txtpventa20":"De 2 a 50 caracteres, máximo 5 palabras","txtpventa21":"Captura el número exterior","txtpventa22":"De mínimo 2 carácteres numericos","txtpventa23":"Captura el número interior","txtpventa24":"Captura la colonia","txtpventa25":"Captura el código postal","txtcpcincodigitos":"Captura mínimo 5 digitos","txtpventa26":"Captura mínimo 6 dígitos","txtpventa27":"Debes capturar mínimo 6 dígitos","txtpventa28":"De mínimo 10 carácteres numericos","txtpventa29":"Captura tu estado","txtpventa30":"Captura tu delegación","txtpventa31":"Captura tu ciudad","txtpventa32":"Captura un correo electrónico","txtpventa33":"El correo no tiene un formato válido","txtpventa34":"Enterado","txtpventa35":"La liga fue copiada en portapapeles","txtswitchpulldown1":"¡Regístrate o inicia sesión para agregarlo a tu lista del súper!","txtswitchpulldown2":"¡Regístrate o inicia sesión para agregarlo a tus favoritos!","txtswitchpulldown3":"¡Regístrate o inicia sesión para agregarlo a tus colecciones!","txtswitchpulldown4":"Regístrate o inicia sesión para poder imprimir tu receta. ¡Es fácil y gratis!","txtswitchpulldown5":"Regístrate o inicia sesión para poder imprimir tu tip. ¡Es fácil y gratis!","txtswitchpulldown6":"Regístrate o inicia sesión para poder utilizar el planeador de menús. ¡Es fácil y gratis!","txtswitchpulldown7":"Para subir una foto necesitas iniciar sesión en Kiwilimón. ¡Es fácil y gratis!","txtswitchpulldown8":"¡Regístrate o inicia sesión para enlazar tu AppleTV a tu cuenta de Kiwilimón!","txtswitchpulldown9":"Bienvenid@","txtswitchpulldown10":"Conéctate con tu red social preferida.","txtlogincheckar1":"Captura tu correo electrónico","txtlogincheckar2":"Correo electrónico mal formado","txtlogincheckar3":"Captura tu contraseña","txtlogincheckar4":"Contraseña demasiado corta","txtlogincheckar5":"Haz clic para conectarte","txtlogincheckar6":"Rellena los campos","txtdologin":"Conectandote...","txtgetlogin":"Recargando la página...","txtcontrasenacheckar1":"Captura tu correo","txtcontrasenacheckar2":"El correo no tiene un formato válido","txtcontrasenacheckar3":"Haz clic para enviar el recordatorio","txtcontrasenacheckar4":"Rellena los campos","txtcontrasenacheckar5":"El correo no tiene un formato válido.","txtdorecordar":"Recordando...","txtgetrecordar1":"Contraseña enviada con éxito","txtgetrecordar2":"Código de validación enviado con éxito","txtvalidarcodigocheckar":"Haz clic para validar","txtdovalidar":"Activando...","txtgetvalidar":"¡Validado!","txtregistrocheckar1":"Captura tu contraseña otra vez","txtregistrocheckar2":"Verificación de Contraseña demasiado corta","txtregistrocheckar3":"Tienes que aceptar las políticas del sitio para registrarte","txtregistrocheckar4":"Haz clic para registrarte","txtregistrocheckar5":"Captura tus apellidos","txtstrong1":"no válida","txtstrong2":"débil","txtstrong3":"buena","txtstrong4":"óptima","txtpswmatch":"Verifique que los campos de contraseña sean iguales","txtvalidamail1":"Error: este correo ya esta registrado. ¿Necesitas recuperar tu contraseña? ","txtvalidamail2":"Recuperar contraseña","txtvalidamail3":"Tal vez me conecte con una Red Social","txtvalidamail4":"Error: el dominio del correo electrónico no tiene un servidor de correos válido. Si crees que es un error, verifica con tu proveedor.","txtvalidamail5":"Error: el correo no tiene un formato adecuado. Verifica como lo escribiste.","txtdoregistro":"Registrando...","txtregistrosocialcheckar1":"El nombre no tiene un formato válido","txtregistrosocialcheckar2":"El apellido no tiene un formato válido","txtregistrosocialcheckar3":"Confirma tus datos","txtvalidamailsocial1":"Error: este correo ya esta registrado. ¿Necesitas recuperar tu contraseña?","txtvalidamailsocial2":"Recuperar contraseña","txtvalidamailsocial3":"Error: el dominio del correo electrónico no tiene un servidor de correos válido. Si crees que es un error, verifica con tu proveedor.","txtvalidamailsocial4":"Error: el correo no tiene un formato adecuado. Verifica como lo escribiste.","txtdoenlaceregistro":"Enlazando...","txtgetenlazarregistro":"Recargando la página...","txtenviarchefimagen1":"Error: Ya hay una imagen que se esta subiendo. Espera un poco, a veces se puede tardar algunos minutos.","txtenviarchefimagen2":"Trabajando...","txtenviarchefimagen3":"Error: debes subir una imagen antes de validarla.","txtenviarchefimagen4":"Subir la imagen se ha cancelado.","txtimagenrespuestachef":"Ocurrio un problema al guardar tu imagen:","txtcerrarSubirfotochef":"Validar","txtenviarimagen1":"Error: Ya hay una imagen que se esta subiendo en la receta. Espera un poco, a veces se puede tardar algunos minutos.","txtenviarimagen2":"Error: debes subir una imagen antes de validarla.","txtdocomprar1":"Gracias por comprar estos ingredientes.","txtdocomprar2":"Cuando confirmas ganarás 5 puntos, y estarás redirigido al sitio de Superama.","txtdocomprar3":"Sigue participando para ganar el Reto Kiwilimón.","txtseguirachef":"Siguiendo","txtchefseguido1":"Amigos","txtchefseguido2":"Se ha agregado","txtchefseguido3":"a tus amigos que sigues","txtchefseguido4":"Ya sigues a este amigo","txtcerrar":"Cerrar","txtconfirmacerrarcuenta1":"Se borraran todos tus datos de los sitios Kiwilimón.","txtconfirmacerrarcuenta2":" ¿Estás seguro?","txtconfirmacerrarcuenta3":"Estoy de acuerdo","txtcierracuenta1":"Listo, tu cuenta se desactivo","txtcierracuenta2":"Ocurrio un error. Por favor ponte encontacto con nosotros","txtgetusarDatos":"Cambiamos tu usuario principal","txtgetdesenlazarcuenta":"Desactivamos tu cuenta. ","txtusarestosdatos":"No es una Red Social valida","txtguardaidioma1":"Listo, cambiaste de idioma preferido.","txtguardaidioma2":"No se pudo cambiar el idioma.","txtconfirmaidioma":"¿Estás seguro que quieres cambiar el idioma?","errorcargaimagen":"Ocurrió un error al cargar la imagen, por favor inténtalo de nuevo mas tarde."};WA.i18n.loadMessages(translation);KL.version='4.00.01';KL.sitedomain='https://www.kiwilimon.com';KL.cdndomain='https://cdn.kiwilimon.com';KL.sitedomains='https://www.kiwilimon.com';KL.cdndomains='https://cdn.kiwilimon.com';KL.graphdomains='https://graph.kiwilimon.com';KL.identitydomains='https://identity.kiwilimon.com';KL.imdomains='https://im.kiwilimon.com';KL.grdomains='https://gr.kiwilimon.com';KL.ssl=(document.location.protocol=="https:");KL.devel=false;KL.adunit='kiwi_';KL.keywords=null;KL.Modules={};if(KL.language=='es')
{WA.Date.setNames([WA.i18n.getMessage("loaderdia1"),WA.i18n.getMessage("loaderdia2"),WA.i18n.getMessage("loaderdia3"),WA.i18n.getMessage("loaderdia4"),WA.i18n.getMessage("loaderdia5"),WA.i18n.getMessage("loaderdia6"),WA.i18n.getMessage("loaderdia7")],[WA.i18n.getMessage("loaderdiamin1"),WA.i18n.getMessage("loaderdiamin2"),WA.i18n.getMessage("loaderdiamin3"),WA.i18n.getMessage("loaderdiamin4"),WA.i18n.getMessage("loaderdiamin5"),WA.i18n.getMessage("loaderdiamin6"),WA.i18n.getMessage("loaderdiamin7")],[WA.i18n.getMessage("loadermes1"),WA.i18n.getMessage("loadermes2"),WA.i18n.getMessage("loadermes3"),WA.i18n.getMessage("loadermes4"),WA.i18n.getMessage("loadermes5"),WA.i18n.getMessage("loadermes6"),WA.i18n.getMessage("loadermes7"),WA.i18n.getMessage("loadermes8"),WA.i18n.getMessage("loadermes9"),WA.i18n.getMessage("loadermes10"),WA.i18n.getMessage("loadermes11"),WA.i18n.getMessage("loadermes12")],[WA.i18n.getMessage("loadermesmin1"),WA.i18n.getMessage("loadermesmin2"),WA.i18n.getMessage("loadermesmin3"),WA.i18n.getMessage("loadermesmin4"),WA.i18n.getMessage("loadermesmin5"),WA.i18n.getMessage("loadermesmin6"),WA.i18n.getMessage("loadermesmin7"),WA.i18n.getMessage("loadermesmin8"),WA.i18n.getMessage("loadermesmin9"),WA.i18n.getMessage("loadermesmin10"),WA.i18n.getMessage("loadermesmin11"),WA.i18n.getMessage("loadermesmin12")]);}
var globalcounter=1;KL.onLoad=function()
{KL.pageloaded=true;onLoad();}
KL.manageError=function(e)
{var r=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/bitacora','POST',null,null,false);r.addParameter('data',''+e+'\n'+e.stack);r.addParameter('device','pc');r.send();console.log('Hubo un error en el código. Se notificó al equipo de desarrollo, y ya estan trabajando en ello.');}
KL.manageImageError=function(img,clave)
{img.src=KL.identitydomains+'/missingimage?client='+clave;}
function onLoad()
{getIdentity();var pulldown=window.location.href.match(/\?pulldown/g);if(pulldown)
{switchpulldown();}
var registro=window.location.href.match(/\?registro/g);if(registro)
{switchpulldown();mostrarregistro();}
var valida=window.location.href.match(/\?validar/g);if(valida)
{switchpulldown();mostrarvalidacodigoactivacion();}
var registrado=window.location.href.match(/\?registrado/g);if(registrado)
{}
cargaImagenes('postload');cargaImagenes('toload');resize();WA.Managers.event.on('resize',window,resize,true);WA.Managers.event.on('scroll',window,scroll,true);var URLsecretos=ObtenerURL();if(URLsecretos=='supersecretos')
WA.toDOM('header-menu-receta').setAttribute('onmouseover','abrirmenudata("supersecretos", event)');cargaexterior();getPageData();setTimeout(recon,5000);}
function getPageData()
{var callback=null;var r=WA.Managers.ajax.createRequest("/listeners/getpagedata",'POST',null,callback,false);r.addParameter('page',document.location.pathname);r.send();}
function escondeBtnFenosa(){WA.toDOM('btn_fenosa').style.display='none';}
function loadexterncode(src,text,listener,cfasync)
{WebFontConfig={google:{families:['Source+Sans+Pro:200,300,400,600,700,900:latin','Dancing+Script::latin','Great+Vibes::latin','Baloo+Paaji::latin','Parisienne::latin','Oswald::latin','Sail::latin','Amatic+SC:400,700:latin','Diplomata+SC::latin','Bree+Serif::latin','Lato:300,400,700:latin',]}};(function(){var wf=document.createElement('script');wf.src=('https:'==document.location.protocol?'https':'http')+'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';wf.type='text/javascript';wf.async='true';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(wf,s);})();var s=document.createElement('script');s.type='text/javascript';s.async=true;s.src=src;if(text)s.text=text;if(cfasync!=undefined)
s.setAttribute("data-cfasync",cfasync);if(listener)
{s.onload=listener;s.onreadystatechange=function(){if(this.readyState=='complete'){listener();}};}
document.getElementsByTagName('head')[0].appendChild(s);}
function cargaexterior()
{loadexterncode("//www.googletagservices.com/tag/js/gpt.js");loadexterncode("https://apis.google.com/js/platform.js",'',googledone);loadexterncode("https://www.gstatic.com/firebasejs/3.6.5/firebase.js",'',firebasedone);loadexterncode("https://connect.facebook.net/"+KL.locale+"/sdk.js#xfbml=1&version=v3.0&appId=250305718425857");loadexterncode("https://sdk.accountkit.com/"+KL.locale+"/sdk.js",'',initAccKit);!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/'+KL.locale+'/fbevents.js');fbq('init','1042944149056063');fbq('track','PageView');}
function cargaImagenes(clase)
{var imgNode=document.getElementsByClassName(clase);if(imgNode)
{for(var id=0;id<imgNode.length;id++)
{imgNode[id].src=imgNode[id].getAttribute("toload");}}}
var recon_time=30000;function recon()
{setTimeout(recon,recon_time);recon_time+=10000;var request=WA.Managers.ajax.createRequest(KL.imdomains+'/notificacion','GET','dispositivo=pc',getnotif,true);}
function getnotif(request)
{chefNotif=WA.JSON.decode(request.responseText);verificaNotificacion(chefNotif);}
var chefready=false;var chefcode=null;var cheflogged=false;var tempTimeDelta=null;var pathArray=null;function getIdentity()
{var request=WA.Managers.ajax.createRequest(KL.imdomains+'/chef','GET','dispositivo=pc',getchef,true);}
var ta=null;var _exiq=_exiq||[];var _listenerchef={};var idiomacookie=null;function getchef(request)
{chefcode=WA.JSON.decode(request.responseText);KL.setCookie('X-FORWARDED-FOR',chefcode.ip,null,"kiwilimon.com");chefready=true;cheflogged=!!chefcode.chef;var ibrowser=navigator.language||navigator.userLanguage||'es';var idiomabrowser=ibrowser.substring(0,2);idiomacookie=KL.getCookie('kl_idioma');if(!idiomacookie)
{if(KL.language!=idiomabrowser&&!(chefcode.lang=='es'&&idiomabrowser=='en'))
{}}
if(KL.language=='es')
{WA.toDOM('idiomaes_activo').style.display='table-cell';WA.toDOM('idiomaen_activo').style.display='none';WA.toDOM('espanol-inactivo').style.display='none';WA.toDOM('espanol-activo').style.display='inline-table';WA.toDOM('ingles-inactivo').style.display='inline-table';WA.toDOM('ingles-activo').style.display='none';}
else
{WA.toDOM('idiomaen_activo').style.display='table-cell';WA.toDOM('idiomaes_activo').style.display='none';WA.toDOM('ingles-inactivo').style.display='none';WA.toDOM('ingles-activo').style.display='inline-table';WA.toDOM('espanol-inactivo').style.display='inline-table';WA.toDOM('espanol-activo').style.display='none';}
if(chefcode.tiemposervidor)
chefDeltaTime=(new Date().getTime())-(chefcode.tiemposervidor*1000);else
chefDeltaTime=0;buildClasses();if(cheflogged)
{WA.toDOM('header-user-avatarfoto').style.backgroundImage="url('"+chefcode.chef.i+"'), url('"+KL.identitydomains+"/missingimage?client="+chefcode.chef.k+"')";WA.toDOM('header-user-avatarfoto').title=chefcode.chef.n;WA.toDOM('notif-nombre').innerHTML=chefcode.chef.n;WA.toDOM('chef-cantidad-recetas').innerHTML=chefcode.chef.r;WA.toDOM('chef-cantidad-colecciones').innerHTML=chefcode.chef.colecciones;WA.toDOM('chef-cantidad-favoritos').innerHTML=chefcode.chef.favoritos;WA.toDOM('chef-cantidad-listasuper').innerHTML=chefcode.chef.listasuper;WA.toDOM('chef-cantidad-seguidores').innerHTML=chefcode.chef.seguidores;WA.toDOM('header-notif').className='';}
else
{WA.toDOM('content-usuario-nologged').style.display='block';ta=KL.getCookie('tsnotifglobal');}
for(var i in _listenerchef)
{_listenerchef[i]();}}
function registrolistenerchef(id,listener)
{_listenerchef[id]=listener;}
function googledone()
{gapi.load("auth2",initAuth);}
function initAuth()
{auth2=gapi.auth2.init({client_id:'283529264243-vvdq0isu1kiu6ic5rob68ngf2imok0j7.apps.googleusercontent.com'});auth2.currentUser.listen(KL.Modules.googleplus.signin);}
function firebasedone()
{var config={client_id:'283529264243-vvdq0isu1kiu6ic5rob68ngf2imok0j7.apps.googleusercontent.com',authDomain:"kiwilimon-app.firebaseapp.com",databaseURL:"https://kiwilimon-app.firebaseio.com",storageBucket:"kiwilimon-app.appspot.com",messagingSenderId:"283529264243"};firebase.initializeApp(config);}
function initAccKit()
{AccountKit_OnInteractive=function(){AccountKit.init({appId:"250305718425857",state:"hash123424y2i4y2ui4y2iyu42ui4y23uy4",version:"v1.1",fbAppEventsEnabled:true,debug:true});};}
this.llenaRegistro=llenaRegistro;function llenaRegistro(chef)
{if(chef.estatus=='OK')
{ga('send','event','im','loginsocial',chef.redsocial+'/pc/ok',null);setTimeout(function(){proccessChef(chef);},100);return;}
else if(chef.estatus=='REGISTRO'&&WA.toDOM('content-datos'))
{proccessChef(chef);return;}
else if(chef.estatus=='REGISTRO')
{ga('send','event','im','info/registrosocial',chef.redsocial+'/pc/inicio',null);proccessChef(chef);}
else if(chef.estatus=='Error')
{ga('send','event','im','error/registrosocial',chef.redsocial+'/pc/'+chef.code,null);alerta(chef.mensaje);}}
function proccessChef(chef)
{var reload=true;if(chef.estatuscorreo==="2")
{reload=false;fillCompletaInfo(chef);mostrarbloque('enlaza');}
if(reload)
reloadpage(true);}
function fillCompletaInfo(chef)
{var CAMPO_NOMBRE="registronombresocial";var CAMPO_APELLIDO="registroapellidosocial";var CAMPO_CORREO="registrousuariosocial";var DIV_IMAGEN="socialenlazarfoto";if(WA.toDOM(CAMPO_NOMBRE))
WA.toDOM(CAMPO_NOMBRE).value=chef.nombre;if(WA.toDOM(CAMPO_APELLIDO))
WA.toDOM(CAMPO_APELLIDO).value=chef.apellido;if(WA.toDOM(CAMPO_CORREO))
WA.toDOM(CAMPO_CORREO).value=chef.correo;if(WA.toDOM(DIV_IMAGEN))
{WA.toDOM(DIV_IMAGEN).style.backgroundImage="url("+chef.avatar+")";WA.toDOM(DIV_IMAGEN).style.backgroundSize="cover";}}
function reloadpage(registro)
{var disc=window.location.href.match(/desconectar/g);if(disc)
document.location.href='/';else if(registro)
window.location=window.location+'?registrado=1';else
window.location.reload();}
function filldatossocial(datos)
{if(datos.redsocial=='fb')
WA.toDOM('socialenlazarprovider').innerHTML=WA.i18n.getMessage("txtfilldatossocial1");else if(datos.redsocial=='google')
WA.toDOM('socialenlazarprovider').innerHTML=WA.i18n.getMessage("txtfilldatossocial2");else if(datos.redsocial=='acckit')
WA.toDOM('socialenlazarprovider').innerHTML=WA.i18n.getMessage("txtfilldatossocial3");else
WA.toDOM('socialenlazarprovider').innerHTML=WA.i18n.getMessage("txtfilldatossocial4");WA.toDOM('registroredsocial').value=datos.redsocial;WA.toDOM('registroguidsocial').value=datos.clave;if(datos.nombre)
{WA.toDOM('socialenlazarnombre').innerHTML=datos.nombre;WA.toDOM('registronombresocial').value=datos.nombre;WA.toDOM('registronombresocial').readOnly=true;}
else
WA.toDOM('registronombresocial').readOnly=false;if(datos.apellido)
{WA.toDOM('socialenlazarapellido').innerHTML=datos.apellido;WA.toDOM('registroapellidosocial').value=datos.apellido;WA.toDOM('registroapellidosocial').readOnly=true;}
else
WA.toDOM('registroapellidosocial').readOnly=false;if(datos.correo)
{WA.toDOM('socialenlazarcorreo').innerHTML=datos.correo;WA.toDOM('registrousuariosocial').value=datos.correo;WA.toDOM('registrousuariosocial').readOnly=true;}
else
WA.toDOM('registrousuariosocial').readOnly=false;if(datos.sexo&&datos.sexo!='X')
WA.toDOM('socialenlazarsexo').innerHTML=WA.i18n.getMessage("txtfilldatossocial5")+': '+(datos.sexo=='M'?WA.i18n.getMessage("txtfilldatossocial6"):WA.i18n.getMessage("txtfilldatossocial7"));if(datos.nacimiento)
WA.toDOM('socialenlazarnacimiento').innerHTML=WA.i18n.getMessage("txtfilldatossocial8")+': '+datos.nacimiento;if(datos.avatar){WA.toDOM('socialenlazarfoto').style.backgroundImage="url('"+datos.avatar+"')";WA.toDOM('socialenlazarfoto').style.backgroundSize="cover";}
if(datos.redsocial=='acckit')
{WA.toDOM('socialenlazarnombre').innerHTML=WA.i18n.getMessage("txtfilldatossocial9")+': '+datos.prefijo+' '+datos.numero;WA.toDOM('socialenlazarcorreo').innerHTML='ID: '+datos.id;}}
this.desconectatodo=desconectatodo;function desconectatodo()
{fbLogoutUser();signOut();var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/login','POST','ordenSeguridad=desconectar',getlogout,true);}
function getlogout(r)
{document.location='/';}
function fbLogoutUser()
{if(FB)
{FB.getLoginStatus(function(response){if(response&&response.status==='connected'){FB.logout(function(response){console.log('User signed out.');});}});}}
var auth2=null;function signOut(){auth2=gapi.auth2.getAuthInstance();auth2.signOut().then(function(){console.log('User signed out.');});}
function buildClasses()
{var cl=chefready?(cheflogged?'logged':'not-logged'):'user-pending';var touch=!!('ontouchstart'in document.documentElement);cl+=touch?' touch':'';if(tamanochico)
cl+=' tamanochico';window.document.body.className=cl;}
var globalwidth=WA.browser.getWindowWidth();var tamanochico=false;resize=function()
{globalwidth=WA.browser.getWindowWidth();tamanochico=(globalwidth<640);buildClasses();scrollheader();ajustarpulldown();scrollfooter();}
scroll=function()
{scrollheader();ajustarpulldown();scrollfooter();}
function ObtenerURL()
{pathArray=window.location.pathname.split('/');return pathArray[1];}
function setUpAgknTag(tag)
{tag.setBpId("kiwilimon");}
function buildAd(N,handle,type,prepend,keywords)
{try
{if(!KL.adunit)
return;var preid=N.getAttribute("preid");var presize=N.getAttribute("presize");var preoop=N.getAttribute("preoop");var preposition=N.getAttribute("position");var pretype=N.getAttribute("pretype");if(type=='replace')
{var adunit=prepend+preid;var newid='div'+globalcounter+'_'+adunit;globalcounter++;var style=N.getAttribute("style");var newnode=WA.createDomNode('div',newid,'');newnode.setAttribute("style",style);newnode.setAttribute("presize",presize);newnode.setAttribute("preid",preid);newnode.setAttribute("preposition",preposition);newnode.setAttribute("pretype",pretype);N.parentNode.insertBefore(newnode,N);N.parentNode.removeChild(N);}
else
{var adunit=N.getAttribute("adunit");var newid=N.id;}
var position='';var type='';if(preposition)
position='.setTargeting("position", "'+preposition+'")';if(pretype)
type='.setTargeting("type", "'+pretype+'")';var strkeywords=keywords?'.setTargeting("keywords", '+WA.JSON.encode(keywords)+')':'';slot=googletag.defineSlot("/3879499/kiwi_300x250",[[300,250]],newid).setTargeting("position","top").setTargeting("type","home").addService(googletag.pubads());googletag.cmd.push(function(){googletag.display(newid);});if(window.googletag&&googletag.apiReady){sendAdserverRequest(null,[slot]);}
else
setTimeout(function(){sendAdserverRequest(null,[slot]);},500);N.className='';}
catch(e)
{ga('send','event','publicidad','error/loader','pc/99',null);KL.manageError(e);}}
var buildAdsInterval=null;function buildAds(handle,type,prepend,keywords)
{if(!KL.adunit||!googletag.defineSlot)
{if(buildAdsInterval===null)
{buildAdsInterval=setInterval(function(){buildAds(handle,type,prepend,keywords);},1000);}
return;}
var adNodes=document.getElementsByClassName(handle);var maximo=20;var i=0;if(adNodes)
{while(adNodes[0])
{buildAd(adNodes[0],handle,type,prepend,keywords);if(i==maximo)
{break;}
i++;}}
if(!(buildAdsInterval===null))
clearInterval(buildAdsInterval);}
function formatearDinero(numero)
{numero=parseFloat(numero).toFixed(2);var splitNum=numero.split(',');splitNum[0]=splitNum[0].replace(/\B(?=(\d{3})+(?!\d))/g,',');numero=splitNum.join('.');return'$'+numero+' MXN';}
KL.setCookie=function(id,value,exdays,domain)
{var exdate=new Date();exdate.setDate(exdate.getDate()+exdays);var c_value=escape(value)+((exdays==null)?"":"; expires="+exdate.toUTCString());document.cookie=id+"="+c_value+(domain?";path=/;domain="+domain:"");}
KL.getCookie=function(id)
{var c_value=null;var c_start=document.cookie.indexOf(" "+id+"=");if(c_start==-1)
c_start=document.cookie.indexOf(id+"=");if(c_start!=-1)
{c_start=document.cookie.indexOf("=",c_start)+1;var c_end=document.cookie.indexOf(";",c_start);if(c_end==-1)
c_end=document.cookie.length;c_value=unescape(document.cookie.substring(c_start,c_end));}
return c_value;}
KL.pad0=function(n)
{return n<10?'0'+n:n}
KL.popup={};KL.popup.current=null;KL.popup.noclose=null;KL.popup.hook=null;KL.popup.show=function(nodeid,noclose,hook)
{if(KL.popup.current)
KL.popup.hide();WA.toDOM('popup').appendChild(WA.toDOM(nodeid));KL.popup.current=nodeid;KL.popup.noclose=noclose;WA.toDOM(nodeid).style.display='block';WA.toDOM('popup').style.display='block';KL.popup.showbg(noclose);if(hook)
KL.popup.hook=hook;}
KL.popup.hide=function()
{if(KL.popup.current)
{WA.toDOM('popup-container').appendChild(WA.toDOM(KL.popup.current));KL.popup.current=null;}
WA.toDOM('popup').style.display='none';WA.toDOM('pagecontainer').style.position='relative';KL.popup.hidebg();if(KL.popup.hook)
{KL.popup.hook();KL.popup.hook=null;}}
KL.popup.showbg=function(noclose)
{WA.toDOM('popup-background').style.display='block';if(!noclose)
{WA.toDOM('popup-background').onclick=KL.popup.hide;WA.toDOM('popup-background').ontouch=KL.popup.hide;}
else
{WA.toDOM('popup-background').onclick=WA.nothing;WA.toDOM('popup-background').ontouch=WA.nothing;}}
KL.popup.hidebg=function()
{WA.toDOM('popup-background').style.display='none';if(WA.toDOM('mp_herramientas-flotantes')){WA.toDOM('mp_herramientas-flotantes').style.top='60px';}}
KL.direccionarsitio=function()
{if(KL.language=='es')
{window.location.href=WA.toDOM('kl_ingles').href;}
else
{window.location.href=WA.toDOM('kl_espanol').href;}
KL.cookieCambiarIdioma();}
KL.cookieCambiarIdioma=function()
{KL.setCookie('kl_idioma',1,365,'kiwilimon.com');}
KL.popup.abreIdioma=function()
{KL.popup.show('popupidioma');}
KL.popup.cierraIdioma=function()
{KL.cookieCambiarIdioma();KL.popup.hide();}
var headeridioma=false;KL.popup.abrecuadroidioma=function()
{if(!headeridioma)
{WA.toDOM('idiomas').style.display='block';headeridioma=true;}
else
{WA.toDOM('idiomas').style.display='none';headeridioma=false;}}
KL.direccionaES=function()
{window.location.href=WA.toDOM('kl_espanol').href;WA.toDOM('espanol-inactivo').style.display='none';WA.toDOM('espanol-activo').style.display='inline-table';WA.toDOM('ingles-inactivo').style.display='inline-table';WA.toDOM('ingles-activo').style.display='none';}
KL.direccionaEN=function()
{window.location.href=WA.toDOM('kl_ingles').href;WA.toDOM('ingles-inactivo').style.display='none';WA.toDOM('ingles-activo').style.display='inline-table';WA.toDOM('espanol-inactivo').style.display='inline-table';WA.toDOM('espanol-activo').style.display='none';}
var hrFlotanteClose=false;function closeHF()
{hrFlotanteClose=true;WA.toDOM('herramientas-flotantes').style.display="none";}
function actualizaanuncios()
{buildAds('adnetwork','replace',KL.adunit,KL.keywords);}
function herramientaFlotante(scrollLocation)
{if(!WA.toDOM('herramientas-flotantes'))
return;if(tamanochico)
{WA.toDOM('herramientas-flotantes').style.display="none";}
else
{if(scrollLocation>=350)
{if(hrFlotanteClose)
return;if(window.innerWidth<768)
{WA.toDOM('herramientas-flotantes').style.display="none";}
else
WA.toDOM('herramientas-flotantes').style.display="block";}
else
{hrFlotanteClose=false;WA.toDOM('herramientas-flotantes').style.display="none";}}}
function moverizq(node)
{var x=parseInt(WA.toDOM(node).style.left,10)+90;if(x>0)
x=0;WA.toDOM(node).style.left=x+'px';}
function moverder(node)
{var x=parseInt(WA.toDOM(node).style.left,10)-90;if(x<-450)
x=-450;WA.toDOM(node).style.left=x+'px';}
var panelids={};function getmax(clave)
{if(!panelids[clave])
return;if(!panelids[clave].panel)
return;var max=0;for(var i=0;i<panelids[clave].panel.childNodes.length;i++)
{var x=WA.browser.getNodeNodeLeft(panelids[clave].panel.childNodes[i],panelids[clave].panel);if(x!=undefined)
x+=WA.browser.getNodeWidth(panelids[clave].panel.childNodes[i]);if(x!=undefined&&x>max)
max=x;}
if(max>WA.browser.getNodeWidth(panelids[clave].container))
{panelids[clave].container.style.width='90%';WA.toDOM('panelcontrol-izq'+clave).style.width='5%';WA.toDOM('panelcontrol-der'+clave).style.width='5%';WA.toDOM('panelcontrol-izq'+clave).style.display='';WA.toDOM('panelcontrol-der'+clave).style.display='';WA.toDOM('panelcontrol-izq'+clave).className='control-izq off';panelids[clave].max=max-WA.browser.getNodeWidth(panelids[clave].container);}
else
{WA.toDOM('panelcontrol-izq'+clave).style.display='none';WA.toDOM('panelcontrol-der'+clave).style.display='none';}}
function startpanelid(clave,hop)
{panelids[clave]={};panelids[clave].container=WA.toDOM('panelcontainer'+clave);panelids[clave].panel=WA.toDOM('panelid'+clave);panelids[clave].hop=hop;getmax(clave);}
function panelmoverizq(clave)
{var x=parseInt(panelids[clave].panel.style.left,10)+panelids[clave].hop;if(x>=0)
{x=0;WA.toDOM('panelcontrol-izq'+clave).className='control-izq off';}
else
{WA.toDOM('panelcontrol-izq'+clave).className='control-izq';}
WA.toDOM('panelcontrol-der'+clave).className='control-der';WA.get(panelids[clave].panel).move(500,x,null,null,parseInt(panelids[clave].panel.style.left,10));}
function panelmoverder(clave)
{getmax(clave);var x=parseInt(panelids[clave].panel.style.left,10)-panelids[clave].hop;if(x<=-panelids[clave].max)
{x=-panelids[clave].max;WA.toDOM('panelcontrol-der'+clave).className='control-der off';}
else
{WA.toDOM('panelcontrol-der'+clave).className='control-der';}
WA.toDOM('panelcontrol-izq'+clave).className='control-izq';WA.get(panelids[clave].panel).move(800,x,null,null,parseInt(panelids[clave].panel.style.left,10));}
function sendnewsletter(field)
{try
{if(field)
var correo=WA.toDOM(field).value;else
var correo=WA.toDOM('newsletter').value;if(!correo||correo=='')
{alerta(WA.i18n.getMessage("txtsendnewsletter"));return;}
var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/newsletter','POST',null,getnewsletter,false);request.addParameter('correo',WA.UTF8.encode(correo));request.send();}
catch(e)
{ga('send','event','im','error/newsletter','nativo/pc/1599',null);KL.manageError(e);}}
function getnewsletter(request)
{try
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','im','newsletter','nativo/pc/ok',null);notifica(WA.i18n.getMessage("txtgetnewsletter"));if(WA.toDOM('newsletter'));WA.toDOM('newsletter').value='';}
else
{alerta(code.mensaje);ga('send','event','im','error/newsletter','nativo/pc/'+code.code,null);}}
catch(e)
{ga('send','event','im','error/newsletter','nativo/pc/1599',null);KL.manageError(e);}}
function getTime()
{now=new Date();if(fecha_fin<now)
{WA.toDOM('counter').innerHTML=WA.i18n.getMessage("txtgetTime1");return;}
days=(fecha_fin-now)/1000/60/60/24;daysRound=Math.floor(days);hours=(fecha_fin-now)/1000/60/60-(24*daysRound);hoursRound=Math.floor(hours);minutes=(fecha_fin-now)/1000/60-(24*60*daysRound)-(60*hoursRound);minutesRound=Math.floor(minutes);seconds=(fecha_fin-now)/1000-(24*60*60*daysRound)-(60*60*hoursRound)-(60*minutesRound);secondsRound=Math.round(seconds);sec=(secondsRound==1)?" "+WA.i18n.getMessage("txtgetTime2"):" "+WA.i18n.getMessage("txtgetTime2");min=(minutesRound==1)?" min | ":" min | ";hr=(hoursRound==1)?" hr | ":" hrs | ";dy=(daysRound==1)?" "+WA.i18n.getMessage("txtgetTime3")+" | ":" "+WA.i18n.getMessage("txtgetTime4")+" | ";WA.toDOM('counter').innerHTML=daysRound+dy+hoursRound+hr+minutesRound+min+secondsRound+sec;newtime=window.setTimeout(getTime,1000);}
function es_corta(str)
{return!!{'de':1,'la':1,'que':1,'el':1,'en':1,'y':1,'a':1,'los':1,'del':1,'se':1,'las':1,'por':1,'un':1,'para':1,'con':1,'no':1,'una':1,'su':1,'al':1,'es':1,'lo':1,'como':1,'mas':1,'pero':1,'sus':1,'le':1,'ya':1,'o':1,'fue':1,'este':1,'ha':1,'si':1,'porque':1,'esta':1,'son':1,'entre':1,'esta':1,'cuando':1,'muy':1,'sin':1,'sobre':1,'ser':1,'tambien':1,'me':1,'hasta':1,'hay':1,'donde':1,'quien':1,'desde':1,'todo':1,'nos':1,'durante':1,'todos':1,'uno':1,'les':1,'ni':1,'contra':1,'otros':1,'ese':1,'eso':1,'ante':1,'ellos':1,'e':1,'esto':1,'mi':1,'antes':1,'algunos':1,'que':1,'unos':1,'yo':1,'otro':1,'otras':1,'otra':1,'el':1,'tanto':1,'esa':1,'estos':1,'mucho':1,'quienes':1,'nada':1,'muchos':1,'cual':1,'poco':1,'ella':1,'estar':1,'estas':1,'algunas':1,'algo':1,'nosotros':1,'mi':1,'mis':1,'tu':1,'te':1,'ti':1,'tu':1,'tus':1,'ellas':1,'nosotras':1,'vosotros':1,'vosotras':1,'os':1,'mio':1,'mia':1,'mios':1,'mias':1,'tuyo':1,'tuya':1,'tuyos':1,'tuyas':1,'suyo':1,'suya':1,'suyos':1,'suyas':1,'nuestro':1,'nuestra':1,'nuestros':1,'nuestras':1,'vuestro':1,'vuestra':1,'vuestros':1,'vuestras':1,'esos':1,'esas':1,'estos':1,'estas':1,'esta':1,'este':1,'mejor':1,'mejores':1}[str.toLowerCase()];}
function separarpalabras(str)
{var arr=str.split(' ');var n=arr.length;if(n==1)
return'<em>'+str+'</em>';var l1='',l2='';if(n==2)
{if(es_corta(arr[0])||es_corta(arr[1]))
l1=arr[0]+' '+arr[1];else
{l1=arr[0];l2=arr[1];}}
else
{var f0=es_corta(arr[0]),f1=es_corta(arr[1]),f2=es_corta(arr[2]);if(f0&&(f1||f2))
{if(n==3)
l1=arr[0]+' '+arr[1]+' '+arr[2];else
{l1=arr.shift()+' '+arr.shift()+' '+arr.shift();l2=arr.join(' ');}}
else if(f0&&!f1&&!f2)
{l1=arr.shift()+' '+arr.shift();l2=arr.join(' ');}
else
{l1=arr.shift();l2=arr.join(' ');}}
return'<em>'+l1+'</em> '+l2;}
function muestraFeed(tipo)
{var selected='none';var feedsByTipo={'recomendado':WA.toDOM('feedrecomendado'),'popular':WA.toDOM('feedpopular'),'nuevo':WA.toDOM('feednuevo'),'home':WA.toDOM('feedcontainer')};if(feedsByTipo.hasOwnProperty(tipo)&&(feedsByTipo[tipo].style.display==='block'))
return;ocultarFeedsPrincipales();if(feedsByTipo[tipo].childNodes.length===1)
animacionEspera(true);switch(tipo){case'recomendado':WA.toDOM('feedrecomendado').style.display='block';KL.Modules.feed.nuevo('feedrecomendado');selected=1;break;case'popular':WA.toDOM('feedpopular').style.display='block';KL.Modules.feed.nuevo('feedpopular');selected=2;break;case'nuevo':WA.toDOM('feednuevo').style.display='block';KL.Modules.feed.nuevo('feednuevo');selected=0;break;case'home':default:WA.toDOM('feedcontainer').style.display='block';KL.Modules.feed.nuevo('feedcontainer');selected=0;break;}
var contenedorBotones=document.getElementById('menufeedhome');var botonesFeed=contenedorBotones.getElementsByClassName('caja_inline');if(selected==='none')
return;for(var i=0;i<botonesFeed.length;i++)
{var boton=botonesFeed[i];var botonSeleccionado=(i===selected);var tieneClaseSelected=(boton.classList.contains('on'));if(botonSeleccionado)
{if(!tieneClaseSelected)
boton.classList.add('on');}
else
if(tieneClaseSelected)
boton.classList.remove('on');}}
function ocultarFeedsPrincipales()
{if(WA.toDOM('feedcontainer'))
WA.toDOM('feedcontainer').style.display='none';if(WA.toDOM('feedrecomendado'))
WA.toDOM('feedrecomendado').style.display='none';if(WA.toDOM('feedpopular'))
WA.toDOM('feedpopular').style.display='none';if(WA.toDOM('feednuevo'))
WA.toDOM('feednuevo').style.display='none';}
function animacionEspera(mostrar)
{if(WA.toDOM('div_cargandofeedanim'))
{if(mostrar===true){if(KL.devel)
console.log('muestro animacion +');WA.toDOM('div_cargandofeedanim').style.display='block';}
else if(mostrar===false){if(KL.devel)
console.log('oculto animacion -');WA.toDOM('div_cargandofeedanim').style.display='none';}}}
function abrir(tipo,clave,sufijo)
{sufijo=sufijo||'c';if(tipo.target)
{var aux=getCleanDataFromId(tipo.target);if(aux===null)
return;tipo=aux.tipo;clave=aux.clave;sufijo=aux.sufijo;}
var nodefav=WA.toDOM('tools_fav_'+tipo+'_'+clave+'_'+sufijo);var nodecol=WA.toDOM('tools_col_'+tipo+'_'+clave+'_'+sufijo);var nodelis=WA.toDOM('tools_lis_'+tipo+'_'+clave+'_'+sufijo);var nodemp=WA.toDOM('tools_mp_'+tipo+'_'+clave+'_'+sufijo);var nodesha=WA.toDOM('sombraficha-'+tipo+'-'+clave+'-'+sufijo);nodefav.abierto=true;var start=50;var heightOffset=40;if(nodesha)
nodesha.style.display='block';else
{start=60;heightOffset=50;}
if(nodemp)
{nodemp.style.top=start+'px';start+=heightOffset;}
if(nodelis)
{nodelis.style.top=start+'px';start+=heightOffset;}
if(nodecol)
{nodecol.style.top=start+'px';start+=heightOffset;}
nodefav.style.top=start+'px';}
function cerrar(tipo,clave)
{var sufijo='';if(tipo.target)
{var aux=getCleanDataFromId(tipo.target);if(aux===null)
return;tipo=aux.tipo;clave=aux.clave;sufijo=aux.sufijo;}
var nodefav=WA.toDOM('tools_fav_'+tipo+'_'+clave+'_'+sufijo);var nodecol=WA.toDOM('tools_col_'+tipo+'_'+clave+'_'+sufijo);var nodelis=WA.toDOM('tools_lis_'+tipo+'_'+clave+'_'+sufijo);var nodemp=WA.toDOM('tools_mp_'+tipo+'_'+clave+'_'+sufijo);var nodesha=WA.toDOM('sombraficha-'+tipo+'-'+clave+'-'+sufijo);nodefav.abierto=false;if(nodesha)
nodesha.style.display='none';nodefav.style.top='10px';if(nodecol)
nodecol.style.top='10px';if(nodelis)
nodelis.style.top='10px';if(nodemp)
nodemp.style.top='10px';}
function getCleanDataFromId(node)
{var obj={};if(!node.id)
node=node.parentNode;var auxparamsarray=node.id.split("_");if(typeof(auxparamsarray[2])==="undefined"||typeof(auxparamsarray[3])==="undefined"||typeof(auxparamsarray[4])==="undefined")
return null;obj.tipo=auxparamsarray[2];obj.clave=auxparamsarray[3];obj.sufijo=auxparamsarray[4];return obj;}
KL.Modules.track=new function()
{function trackLoadEpisode(episode)
{var tallerSite=getTallerSiteFromLocation();var event='episodio-'+episode;ga('send','event','tallereskl','carga/'+event,tallerSite,null);fbq('trackCustom','CargaTalleresKl',{'entity':event,'from':tallerSite});if(KL.devel)
console.log('wb-event',event,'tallerSite',tallerSite);}
function trackAutomaticLoad()
{var tallerSite=getTallerSiteFromLocation();var event='reproduccion-automatica';ga('send','event','tallereskl','carga/'+event,tallerSite,null);fbq('trackCustom','CargaTalleresKl',{'entity':event,'from':tallerSite});if(KL.devel)
console.log('wb-event',event,'tallerSite',tallerSite);}
this.trackCargaTemporadasTalleres=trackCargaTemporadasTalleres;function trackCargaTemporadasTalleres()
{var tallerSite=getTallerSiteFromLocation();var event='temporadas';ga('send','event','tallereskl','carga/'+event,tallerSite,null);fbq('trackCustom','CargaTalleresKl',{'entity':event,'from':tallerSite});}
this.loadTalleresEvents=loadTalleresEvents;function loadTalleresEvents()
{var locationSections=document.location.pathname.split('/');if(!(locationSections.includes('talleres-de-cocina')))
return;if(KL.devel)
console.log('wb-talleres-events-loaded');var buttonAutomaticSeasonLoad=document.getElementsByClassName('btnrepautomatica')[0];var seasonContainer=document.getElementById('div_temporada');var episodesContainers=seasonContainer.getElementsByClassName('div_cont_capitulo');var oldActionOne=buttonAutomaticSeasonLoad.getAttribute('onclick');buttonAutomaticSeasonLoad.onclick=function(){try{eval(oldActionOne);}catch(e){if(KL.devel)console.log('trackModule - eval onclick old action failed: '+e)}
trackAutomaticLoad();};for(var i=0;i<episodesContainers.length;i++)
{var episode=episodesContainers[i];episode.onclick=function(){var containerId=this.id;var episodeNumber=containerId.split('-')[2];var aElement=this.getElementsByTagName('a')[0];var goToUrl=aElement.href;trackLoadEpisode(episodeNumber);window.location.href=goToUrl;return false;}
var aElement=episode.getElementsByTagName('a')[0];aElement.onclick=function(){return false;}}
return;var tiendasNodeClassName="div-ficha-tienda";var tiendasNodes=document.getElementsByClassName(tiendasNodeClassName);if(tiendasNodes.length<1)
return;for(var i=0;i<tiendasNodes.length;i++)
{var auxNode=tiendasNodes[i];disableAElementsAndAsignRedirectEvent(auxNode);}}
function getTallerSiteFromLocation()
{var pathname=document.location.pathname;var sections=pathname.split('/');var location='';if(sections[2]&&sections[3])
location+='Temporada '+sections[2]+' Episodio '+sections[3];else
location+='Landing';return location;}
function getTipoTienda()
{var tiposTiendaWithNodeId=[{tipoTienda:'fisico',nodeId:'div_cont_tiendas'},{tipoTienda:'ebook',nodeId:'div_cont_tiendasebook'},{tipoTienda:'usa',nodeId:'div_cont_tiendasusa'}];for(var k=0;k<tiposTiendaWithNodeId.length;k++)
{var tienda=tiposTiendaWithNodeId[k];var tipoTiendaNodeId=tienda.nodeId;var tipoTienda=tienda.tipoTienda;var node=document.getElementById(tipoTiendaNodeId);if(node.style.display!=="none"&&node.style.height!=="0px")
return tipoTienda;}
return'none';}
function notifyAndRedirect()
{var destinationUrl=this.href;try{var tipoTienda=getTipoTienda();var tiendaUrl=new URL(destinationUrl);var dominio=tiendaUrl.host;var eventId='tipo|'+tipoTienda+'|tienda|'+dominio;if(KL.devel)
{console.log('wb-tipo-tienda',tipoTienda);console.log('wb-dominio',tiendaUrl.host);console.log('wb-event-name',eventId);}
ga('send','event','librokl','compra/'+tipoTienda,dominio,null);fbq('trackCustom','CompraLibroKL',{'shopType':tipoTienda,'shop':dominio});}catch(e){if(KL.devel)
console.log('wb-librokl-analytics-error',e);}
window.open(destinationUrl,'_blank');return false;}
function disableAElementsAndAsignRedirectEvent(node)
{var aElements=node.getElementsByTagName("a");if(aElements.length<1)
return;for(var j=0;j<aElements.length;j++)
{var auxAElement=aElements[j];auxAElement.onclick=notifyAndRedirect;}}
this.notifyTipoTienda=notifyTipoTienda;function notifyTipoTienda(tipo)
{ga('send','event','librokl','select',tipo,null);fbq('trackCustom','SelectLibroKL',{'shopType':tipo});if(KL.devel)
{console.log('wb-notif-tipo',tipo);}}
this.loadLibroKiwilimonEvents=loadLibroKiwilimonEvents;function loadLibroKiwilimonEvents()
{if(!(document.location.pathname==="/libro-kiwilimon"))
return;var tiendasNodeClassName="div-ficha-tienda";var tiendasNodes=document.getElementsByClassName(tiendasNodeClassName);if(tiendasNodes.length<1)
return;for(var i=0;i<tiendasNodes.length;i++)
{var auxNode=tiendasNodes[i];disableAElementsAndAsignRedirectEvent(auxNode);}}
this.donateDibujandoUnManana=donateDibujandoUnManana;function donateDibujandoUnManana(donationType)
{var availableTypes=[1,2,3];if(availableTypes.indexOf(donationType)<0)
return;var eventId='';var destinationUrl='';try
{switch(donationType)
{case 1:eventId='donationPaypalNoAmount';destinationUrl='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UQTY53DLWBK8W&source=url';break;case 2:eventId='donationPaypalWithAmount';destinationUrl='https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UQTY53DLWBK8W&source=url';break;case 3:eventId='donationUsa';destinationUrl='https://donate.icfdn.org/npo/fundacion-dibujando-un-manana-fund';break;default:return;}
ga('send','event','donacion','aniversario',eventId,null);fbq('track',eventId);}catch(e){console.log('Exception donateDibujandoUnManana',e);}
window.open(destinationUrl,'_blank');}}
document.addEventListener("DOMContentLoaded",function(){KL.Modules.track.loadLibroKiwilimonEvents();KL.Modules.track.loadTalleresEvents();});KL.Modules.facebook=new function()
{var self=this;var FBresponse=null;var serversent=false;window.fbAsyncInit=function()
{FB.init({appId:'250305718425857',cookie:true,xfbml:true,version:'v3.0'});FB.getLoginStatus(function(response)
{FBlistener(response);});FB.Event.subscribe('auth.login',FBlistener);};function FBlistener(response)
{FBresponse=response;if(chefready)
{FBlisteneratrasado();return;}
registrolistenerchef('facebook',FBlisteneratrasado);}
function FBlisteneratrasado()
{if(cheflogged)
return;if(FBresponse.status==='connected')
{var nodeid=WA.toDOM('fb_id');if(!nodeid||nodeid.innerHTML!=FBresponse.authResponse.userID)
{if(!serversent)
{var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/loginsocial','POST',null,getUserFb,false);request.addParameter('usuario',WA.JSON.encode(FBresponse.authResponse));request.addParameter('device','pc');request.addParameter('redsocial','fb');request.send();serversent=true;}}}
else if(FBresponse.status==='not_authorized')
{var nodeid=WA.toDOM('fb_id');if(nodeid)
{console.log("No autorizado");}}
else
{}}
function getUserFb(request)
{serversent=false;try
{var respuesta=WA.JSON.decode(request.responseText);llenaRegistro(respuesta);}
catch(e)
{ga('send','event','im','error/loginsocial','fb/pc/1699',null);KL.manageError(e);}}
this.getObject=getObject;function getObject()
{return FBresponse;}
this.share=share;function share(shareQuote,shareUrl)
{var url=document.location.href;var quote=false;if(shareUrl&&(typeof(shareUrl)==="string"))
url=shareUrl;if(shareQuote&&(typeof(shareQuote)==="string")&&!(shareQuote===""))
quote=shareQuote;var params={href:url,method:"share",display:"popup"};if(quote)
params.quote=quote;if(url.indexOf('/quiz/')!==-1)
ga('send','event','quiz','quiz/share','share',0);FB.ui(params,null);}}
var flagGP=false;KL.Modules.googleplus=new function()
{var self=this;var googleuser=null;var serversent=false;this.signin=signin;function signin(googleUser)
{googleuser=googleUser;if(googleuser&&flagGP)
{if(!serversent)
{var id_token=googleUser.getAuthResponse().id_token;var id_google=googleUser.getId();var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/loginsocial','POST',null,getUserGo,false);request.addParameter('usuario',WA.JSON.encode(id_token));request.addParameter('id',id_google);request.addParameter('redsocial','google');request.addParameter('device','pc');request.send();serversent=true;}}}
this.signout=signout;function signout()
{}
function getUserGo(request)
{serversent=false;try
{var registro=WA.JSON.decode(request.responseText);llenaRegistro(registro);}
catch(e)
{ga('send','event','im','error/loginsocial','google/pc/1699',null);KL.manageError(e);}}
this.getObject=getObject;function getObject()
{if(googleuser)
return googleuser.getAuthResponse().id_token;return null;}
this.signinV2=signinV2;function signinV2()
{}}
KL.Modules.accountkit=new function()
{var self=this;var init=false;var code=null;var serversent=false;this.smsLogin=smsLogin;function smsLogin()
{var countryCode=document.getElementById("country_code").value;var phoneNumber=document.getElementById("phone_number").value;AccountKit.login('PHONE',{countryCode:countryCode,phoneNumber:phoneNumber},loginCallback);}
this.emailLogin=emailLogin;function emailLogin()
{var emailAddress=document.getElementById("email").value;AccountKit.login('EMAIL',{emailAddress:emailAddress},loginCallback);}
function loginCallback(response)
{if(response.status==="PARTIALLY_AUTHENTICATED")
{code=response.code;if(!serversent)
{var csrf=response.state;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/loginsocial','POST',null,getUserAK,false);request.addParameter('usuario',WA.JSON.encode(code));request.addParameter('device','pc');request.addParameter('redsocial','acckit');request.send();serversent=true;}}
else if(response.status==="NOT_AUTHENTICATED")
{}
else if(response.status==="BAD_PARAMS")
{}}
function getUserAK(request)
{serversent=false;try
{var respuesta=WA.JSON.decode(request.responseText);checkchef();llenaRegistro(respuesta);}
catch(e)
{ga('send','event','im','error/loginsocial','acckit/pc/1699',null);KL.manageError(e);}}
this.getObject=getObject;function getObject()
{if(code)
return code;return null;}}
var tmpScrollPosition=0;var busquedalocked=false;function scrollheader()
{if(movilOpenClose=='open')
return;var scrollLocation=WA.browser.getScrollTop();if(scrollLocation>0&&tamanochico)
{if(tmpScrollPosition>scrollLocation)
switchbusqueda(false);else if(tmpScrollPosition<scrollLocation)
switchbusqueda(true);}
else
{if(!busquedalocked)
switchbusqueda(false);}
if(tmpScrollPosition!=scrollLocation)
busquedalocked=false;tmpScrollPosition=scrollLocation;if(WA.toDOM('receta-intro'))
herramientaFlotante(scrollLocation);ajustaPaginaTop();}
var invalidateclick=false;function switchbusqueda(ver,event)
{if(invalidateclick)
return;if(WA.toDOM('f_buscar_q')==document.activeElement)
ver=true;WA.toDOM('header-up').className=(ver?'anim busca':'anim');if(ver)
{busquedalocked=true;}
WA.browser.cancelEvent(event);invalidateclick=true;setTimeout(function(){invalidateclick=false;},500);}
function ajustaPaginaTop(h)
{var h1=WA.browser.getNodeOuterHeight(WA.toDOM('header-up'));var h2=WA.browser.getNodeOuterHeight(WA.toDOM('header-login-container'));if(h!==undefined)
var h=h1+h;else
var h=h1+h2;WA.toDOM('pagecontainer').style.marginTop=h+'px';}
var pilamensajes=[];var mensajesabierto=false;var listenerabierto=null;var iconomensaje=null;var titulomensaje=null;function fijatitulo(icono,titulo)
{iconomensaje=icono;titulomensaje=titulo;}
function notifica(mensaje)
{pilamensajes.push([1,mensaje]);siguientemensaje();}
function alerta(mensaje,boton,listener)
{if(!boton)
boton='OK';pilamensajes.push([2,mensaje,boton,listener]);siguientemensaje();}
function confirma(mensaje,boton1,boton2,listener)
{pilamensajes.push([3,mensaje,boton1,boton2,listener]);siguientemensaje();}
function siguientemensaje()
{if(mensajesabierto)
return;if(pilamensajes.length==0)
return;var data=pilamensajes.shift();var icono=iconomensaje?iconomensaje:'icono_seccion';var titulo=titulomensaje?titulomensaje:WA.i18n.getMessage("txtsiguientemensaje");WA.toDOM('header-notificacionespecial-container').innerHTML='<div class="div_cont_popup_notificacion"><div class="div_popup_centravertical"><div class="div_popup_notificacion anim"><div onclick="cerrarmensaje()" title="Cerrar" class="dejaseguir"></div><div class="divcont_titulo_seccion"><div class="cont_titulo_seccion"><div class="'+icono+'"></div><div class="txt_titulo_seccion">'+titulo+'</div></div></div><div class="div_popup_txt">'+data[1]+'</div>'+
(data[0]==2?'<div class="div_solobtn_cerrar"><button onclick="cerrarmensaje();" class="derecha centro">'+data[2]+'</button><div class="separador_botones_popup"></div></div>':'')+
(data[0]==3?'<div class="div_btns_confirma_cerrar"><div class="div_confirma_izq"><button onclick="cerrarmensaje(1);" class="izquierda">'+data[2]+'</button></div><div class="div_confirma_der"><button onclick="cerrarmensaje(2);" class="derecha">'+data[3]+'</button></div><div class="separador_botones_popup"></div></div>':'')+'</div></div>';if(data[0]==3)
{WA.toDOM('header-notificacionespecial-container').className='anim confirma';if(data[4])
listenerabierto=data[4];}
else if(data[0]==2)
{WA.toDOM('header-notificacionespecial-container').className='anim error';if(data[3])
listenerabierto=data[3];}
else
WA.toDOM('header-notificacionespecial-container').className='anim';KL.popup.show('header-notificacionespecial-container',(data[0]>1));WA.toDOM('header-notificacionespecial-container').style.height='100%';WA.toDOM('header-notificacionespecial-container').style.width='100%';if(data[0]==1)
{setTimeout(cerrarmensajes,2500);}
mensajesabierto=true;}
function cerrarmensaje(id)
{cerrarmensajes();if(listenerabierto)
{listenerabierto(id);listenerabierto=null;}}
function cerrarmensajes()
{KL.popup.hide();mensajesabierto=false;setTimeout(siguientemensaje,550);}
var timermenuusuario={};var idmenuusuario=null;function abrirmenuusuario(id,touch)
{if(!chefready)
return;if(id=='notif')
{WA.toDOM('arrowOpenClose').className='close-arrow';WA.toDOM('exp-bar-header').className='colorBorder';}
if(timermenuusuario[id])
{clearTimeout(timermenuusuario[id]);timermenuusuario[id]=null;}
if(touch&&WA.toDOM(id+'-data-container').style.height!=''&&parseInt(WA.toDOM(id+'-data-container').style.height,10)!=0)
{docerrarmenuusuario(id);return;}
var h=WA.browser.getNodeHeight(WA.toDOM(id+'-data'));WA.toDOM('header-user').style.backgroundColor='#abdc45';WA.toDOM(id+'-data-container').style.height=h+'px';WA.toDOM(id+'-data-container').style.zIndex='-1';if(WA.toDOM('header-'+id+'-arrow'))
WA.toDOM('header-'+id+'-arrow').style.display='block';idmenuusuario=id;ga('send','event','menus','men/usuario','men/usu/abrir',null);}
function cerrarmenuusuario(id)
{if(!chefready)
return;if(id=='notif')
{WA.toDOM('arrowOpenClose').className='open-arrow';WA.toDOM('exp-bar-header').className='';}
timermenuusuario[id]=setTimeout(function(){docerrarmenuusuario(id);},300);}
function docerrarmenuusuario(id)
{timermenuusuario[id]=null;WA.toDOM(id+'-data-container').style.height='0';WA.toDOM(id+'-data-container').style.zIndex='-1';WA.toDOM('header-user').style.backgroundColor='transparent';if(WA.toDOM('header-'+id+'-arrow'))
WA.toDOM('header-'+id+'-arrow').style.display='none';idmenuusuario=null;ga('send','event','menus','men/usuario','men/usu/cerrar',null);}
var idc=null;function showContent(id)
{var height='200px';if(id=='social')
height='100px';if(idc==id)
{WA.toDOM(id).style.height='0px';WA.toDOM(id+'Arrow').className='smallArrow';idc=null;}
else if(idc!=null&&idc!=id)
{WA.toDOM(idc).style.height='0px';WA.toDOM(idc+'Arrow').className='smallArrow';WA.toDOM(id).style.height=height;WA.toDOM(id+'Arrow').className='openArrow';idc=id;}
else if(idc==null)
{WA.toDOM(id).style.height=height;WA.toDOM(id+'Arrow').className='openArrow';idc=id;}
else if(id=='close')
{WA.toDOM(idc).style.height='0px';idc=null;}}
var menudataestatus=0;var timerclosemenu=null;var movilOpenClose='close';var istamanochico=false;var inicioCheck=0;function tamanochicoMenuDrop(event)
{istamanochico=true;if(openCloseNotif==1)
{cerrarNotificaciones();}
if(pulldownopen)
abrirusuario();if(tamanochico)
{if(pathArray[1]=='supersecretos')
{abrirmenudata('supersecretos',event);}
else
{abrirmenudata('receta',event);}}
else
abrirmenudata('familias',event);ga('send','event','menus','men/dropdown','men/drp/openmobile',null);return WA.browser.cancelEvent(event);}
var tempIDopen=null;var tempID=null;function abrirmenudata(id,event)
{WA.toDOM('header-menu-receta').style.background='#6db027';WA.toDOM('header-up').style.boxShadow='none';if(id!=tempIDopen&&tempIDopen&&id!=null)
{if(WA.toDOM('content-'+tempIDopen))
{WA.toDOM('content-'+tempIDopen).style.width='0';WA.toDOM('content-'+tempIDopen).style.display='none';}}
ga('send','event','menus','men/dropdown','men/drp/open'+(id?'/'+id:''),null);if(menudataestatus==0)
{if(id)
tempID=id;var request=WA.Managers.ajax.createRequest('/listeners/getmenu','GET',null,getmenudata,true);menudataestatus=1;}
if(timerclosemenu)
{clearTimeout(timerclosemenu);timerclosemenu=null;}
if(!id)
return;if(istamanochico==true)
{if(movilOpenClose=='close'||movilOpenClose==null)
{var heightdocument=WA.browser.getWindowHeight();var altura=(heightdocument-88);WA.toDOM('movil-menu').style.height='100%';WA.toDOM('header-mobmenu').className='active-menu-tamanochico';movilOpenClose='open';}
else
{WA.toDOM('movil-menu').style.height='0';WA.toDOM('header-mobmenu').className='';movilOpenClose='close';istamanochico=false;}}
else
{var sizeWidth=document.documentElement.clientWidth;if(sizeWidth>500)
{if(sizeWidth<747)
WA.toDOM('header-dropdown-container').style.height='520px';else
WA.toDOM('header-dropdown-container').style.height='340px';}}
fillMenuInfo(id);WA.browser.cancelEvent(event);}
function cerrarmenudata()
{timerclosemenu=setTimeout(function(){docerrarmenudata();},300);}
function docerrarmenudata()
{timerclosemenu=null;WA.toDOM('header-dropdown-container').style.height='0px';WA.toDOM('header-menu-receta').style.background='#8dc63f';WA.toDOM('header-up').style.boxShadow='0 0 4px rgba(0, 0, 0, 0.4)';ga('send','event','menus','men/dropdown','men/drp/cerrar',null);}
var menuInfo=null;function getmenudata(request)
{menuInfo=WA.JSON.decode(request.responseText);WA.toDOM('menu-data-loading').style.display='none';WA.toDOM('menu-data-opciones').style.display='block';fillMenuInfo(tempID);}
function fillMenuInfo(tempID)
{if(tamanochico&&tempIDopen!=null)
{if(WA.toDOM('mct-'+tempIDopen))
{WA.toDOM('mct-'+tempIDopen).style.display='none';}}
var txt='';var existenciaDeNodo=true;if(tamanochico)
{if(!WA.toDOM('existe-tamanochico'+tempID))
existenciaDeNodo=false;}
else
{if(!WA.toDOM('existe-'+tempID))
existenciaDeNodo=false;}
if(!existenciaDeNodo)
{if(menuInfo)
{for(key in menuInfo.menuinfo)
{if(menuInfo.menuinfo.hasOwnProperty(key))
{var tmpCont=0;if(tempID=='receta'&&tamanochico)
{if(key=='familias')
break;if(key=='temporada')
continue;for(info in menuInfo.menuinfo[key])
{if(tmpCont>=6)
continue;if(tmpCont==0)
txt+='<div class="main-tittle-mobmenu mob-rec"><a href="'+menuInfo.menuinfo[key][info].rutapadre+'">'+key+'</a></div>';txt+='<div class="fila" id="'+key+'-data-'+tmpCont+'">';txt+='<div class="img">';txt+='<a href="'+menuInfo.menuinfo[key][info].ruta+'">';txt+='<img class="postloadmenu" toload="'+menuInfo.menuinfo[key][info].imagen+'" src="'+KL.cdndomain+'/img/static/carga-blanco.gif" />';txt+='</a>';txt+='</div>';txt+='<div class="titulo">'+menuInfo.menuinfo[key][info].nombre+'</div>';txt+='</div>';tmpCont=tmpCont+1;}
txt+='<div class="vermas"><a href="'+menuInfo.menuinfo[key][info].rutapadre+'">'+WA.i18n.getMessage("txtfillMenuInfo1")+'<div></div></a></div>';txt+='<div id="existe-tamanochico-'+tempID+'" class="clearboth"></div>';WA.toDOM('mct-'+tempID).innerHTML=txt;}
else if(tempID==key)
{if(tempID=='temporada')
{txt+='<div class="main-tittle-mobmenu"><a href="'+menuInfo.menuinfo.temporada[0].ruta+'">'+WA.toDOM('local-title-id-'+tempID).innerHTML+'</a></div>';txt+=menuInfo.menuinfo["temporalidad"];if(tamanochico)
{txt+='<div id="existe-tamanochico-'+key+'" class="clearboth"></div>';WA.toDOM('mct-'+tempID).innerHTML=txt;}
else
{txt+='<div id="existe-'+key+'"></div>';WA.toDOM('content-'+tempID).innerHTML=txt;}
continue;}
if(tamanochico)
{for(info in menuInfo.menuinfo[key])
{if(tmpCont>=9)
continue;if(tmpCont==0)
txt+='<div class="main-tittle-mobmenu mob-rec"><a href="'+menuInfo.menuinfo[key][info].rutapadre+'">'+WA.toDOM('local-title-id-'+tempID).innerHTML+'</a></div>';txt+='<div class="fila" id="'+key+'-data-'+tmpCont+'">';txt+='<div class="img">';txt+='<a href="'+menuInfo.menuinfo[key][info].ruta+'">';txt+='<img class="postloadmenu" toload="'+menuInfo.menuinfo[key][info].imagen+'" src="'+KL.cdndomain+'/img/static/carga-blanco.gif" />';txt+='</a>';txt+='</div>';txt+='<div class="titulo">'+menuInfo.menuinfo[key][info].nombre+'</div>';txt+='</div>';tmpCont=tmpCont+1;}
txt+='<div id="existe-tamanochico-'+key+'" class="clearboth"></div>';WA.toDOM('mct-'+tempID).innerHTML=txt;}
else
{for(info in menuInfo.menuinfo[key])
{var blank='';var verTodos='ver todos...';if(key=='tienda')
blank=' target="_blank"';if(menuInfo.menuinfo[key][info].extraclass)
txt+='<div class="fila '+menuInfo.menuinfo[key][info].extraclass+'" id="'+tempID+'-data-'+tmpCont+'">';else
txt+='<div class="fila" id="'+tempID+'-data-'+tmpCont+'">';txt+='<div class="titulo"><a href="'+menuInfo.menuinfo[key][info].ruta+'"'+blank+'>'+menuInfo.menuinfo[key][info].nombre+'</a></div>';var columnaEspecial=10;if(!menuInfo.menuinfo[key][info].listalast)
{txt+='<a href="'+menuInfo.menuinfo[key][info].ruta+'"'+blank+'>';txt+='<div class="img">';txt+='<img class="postloadmenu" toload="'+menuInfo.menuinfo[key][info].imagen+'" src="'+KL.cdndomain+'/img/static/carga-blanco.gif" />';txt+='</div>';txt+='</a>';columnaEspecial=5;}
for(var x=0;x<columnaEspecial;x++)
{if(menuInfo.menuinfo[key][info]['nombre-'+x])
{txt+='<div class="childs"><a href="'+menuInfo.menuinfo[key][info]['ruta-'+x]+'"'+blank+'>'+menuInfo.menuinfo[key][info]['nombre-'+x]+'</a></div>';}}
if(menuInfo.menuinfo[key][info].vermas)
txt+='<div class="vermas"><a href="'+menuInfo.menuinfo[key][info].ruta+'"'+blank+'>'+menuInfo.menuinfo[key][info].vermas+'</a></div>';else
txt+='<div class="vermas"><a href="'+menuInfo.menuinfo[key][info].ruta+'"'+blank+'>'+verTodos+'</a></div>';txt+='</div>';tmpCont=tmpCont+1;}
txt+='<div id="existe-'+key+'"></div>';WA.toDOM('content-'+tempID).innerHTML=txt;}}}}
if(tamanochico)
{WA.toDOM('mct-'+tempID).style.display='block';}
else
{WA.toDOM('content-'+tempID).style.display='block';}}
cargaImagenes('postloadmenu');}
else
{if(tamanochico)
{WA.toDOM('mct-'+tempID).style.display='block';WA.toDOM('mct-'+tempID).style.opacity='1';}
else
{WA.toDOM('content-'+tempID).style.width='100%';WA.toDOM('content-'+tempID).style.opacity='1';WA.toDOM('content-'+tempID).style.display='block';}}
if(tamanochico)
{if(tempID=='receta')
WA.toDOM('m-tamanochico-arrow').style.left='11%';if(tempID=='temporada')
WA.toDOM('m-tamanochico-arrow').style.left='32%';if(tempID=='video')
WA.toDOM('m-tamanochico-arrow').style.left='53.5%';if(tempID=='supersecretos')
WA.toDOM('m-tamanochico-arrow').style.left='73%';if(tempID=='concurso')
WA.toDOM('m-tamanochico-arrow').style.left='92%';}
tempIDopen=tempID;}
function cerrartutorialkiwi()
{WA.toDOM('bgtutorialeskiwi').style.display='none';WA.toDOM('tutorial_actividad').style.display='none';WA.toDOM('tutorial_colecciones').style.display='none';WA.toDOM('tutorial_favoritos').style.display='none';WA.toDOM('tutorial_misrecetas').style.display='none';WA.toDOM('tutorial_planeadormenu').style.display='none';WA.toDOM('tutorial_listasuper').style.display='none';WA.toDOM('tutorial_subereceta').style.display='none';WA.toDOM('tutorial_seguidores').style.display='none';WA.toDOM('tutorial_herramientas').style.display='none';WA.toDOM('pagecontainer').style.position='relative';WA.Managers.event.removeKey('esc');}
var tutorialstatus=false;function abrirtutorialkiwi(id_tutorial)
{if(tutorialstatus)
return gettutorial(id_tutorial);var request=WA.Managers.ajax.createRequest('/listeners/tourkiwi','GET',null,function(request){tutorialcargado(request,id_tutorial);},true);}
function tutorialcargado(request,id_tutorial)
{tutorialstatus=true
WA.toDOM('bgtutorialeskiwi').innerHTML=request.responseText;KL.galerias.start();gettutorial(id_tutorial);}
function gettutorial(id_tutorial)
{WA.toDOM('bgtutorialeskiwi').style.display='block';WA.Managers.event.key('esc',cerrartutorialkiwi);if(id_tutorial=='tutorial_actividad')
{WA.toDOM('tutorial_actividad').style.display='block';KL.galerias.getgaleria('g_tut_actividad_d').restart();KL.galerias.getgaleria('g_tut_actividad_m').restart();}
if(id_tutorial=='tutorial_colecciones')
WA.toDOM('tutorial_colecciones').style.display='block';if(id_tutorial=='tutorial_favoritos')
WA.toDOM('tutorial_favoritos').style.display='block';if(id_tutorial=='tutorial_misrecetas')
WA.toDOM('tutorial_misrecetas').style.display='block';if(id_tutorial=='tutorial_planeadormenu')
{WA.toDOM('tutorial_planeadormenu').style.display='block';KL.galerias.getgaleria('g_tut_planeadormenu_d').restart();KL.galerias.getgaleria('g_tut_planeadormenu_m').restart();}
if(id_tutorial=='tutorial_listasuper')
{WA.toDOM('tutorial_listasuper').style.display='block';KL.galerias.getgaleria('g_tut_listasuper_d').restart();KL.galerias.getgaleria('g_tut_listasuper_m').restart();}
if(id_tutorial=='tutorial_subereceta')
{WA.toDOM('tutorial_subereceta').style.display='block';KL.galerias.getgaleria('g_tut_subereceta_d').restart();KL.galerias.getgaleria('g_tut_subereceta_m').restart();}
if(id_tutorial=='tutorial_seguidores')
WA.toDOM('tutorial_seguidores').style.display='block';if(id_tutorial=='tutorial_herramientas')
{WA.toDOM('tutorial_herramientas').style.display='block';KL.galerias.getgaleria('g_tut_herramientas_d').restart();KL.galerias.getgaleria('g_tut_herramientas_m').restart();}
WA.toDOM('pagecontainer').style.position='fixed';}
function mostrar_registro()
{WA.toDOM('bgtutorialeskiwi').style.display='none';switchpulldown();}
var flagBusqueda=false;var timer=null;function buscaRecomendacion()
{flagBusqueda=false;setTimeout(function(){verificaRecomedacion();},0);}
function verificaRecomedacion()
{if(timer)
{clearTimeout(timer);timer=null;}
var numCaracteres=0;var palabra='';numCaracteres=WA.toDOM('f_buscar_q').value.length;palabra=WA.toDOM('f_buscar_q').value;if(numCaracteres>=3)
timer=setTimeout(function(){goSugerencia(palabra);},300);else
WA.toDOM("div_recomendaciones").style.display="none";}
function goSugerencia(palabra)
{var request=WA.Managers.ajax.createRequest(KL.grdomains+'/v6/suggestions','POST',null,recibirsugerencia,false);request.addParameter('q',palabra);request.addParameter('language',KL.language);request.addParameter('device','pc');request.send();}
function recibirsugerencia(request)
{if(flagBusqueda)
return;var resp=WA.JSON.decode(request.responseText);if(resp.quantity>0)
{WA.toDOM("div_recomendaciones").style.display="block";WA.toDOM("resultado_recomendaciones").innerHTML='';var num=0;for(var i in resp.payload)
{WA.toDOM("resultado_recomendaciones").innerHTML+='<div class="sugerencia_individual" onclick="selectSugerencia(\''+resp.payload[i]+'\');">'+resp.payload[i]+'</div>';num++;if(num==10)
break;}
if(num==0)
WA.toDOM("resultado_recomendaciones").innerHTML+='<p>'+WA.i18n.getMessage("txtrecibirsugerencia1")+' </p>';}
else
{alerta(WA.i18n.getMessage("txtrecibirsugerencia1"));}}
function selectSugerencia(sugerencia)
{WA.toDOM('div_recomendaciones').style.display="none";agregaSugerencia(sugerencia);WA.toDOM('resultado_recomendaciones').value='';}
function agregaSugerencia(sugerencia)
{WA.toDOM('f_buscar_q').value=sugerencia;WA.toDOM('div_recomendaciones').style.display="none";WA.toDOM('f_buscar_q').blur();pagina_lista_receta=1;enviabuscar();}
function limpiar_busqueda(){WA.toDOM('f_buscar_q').value='';setTimeout(function(){verificaRecomedacion();},0);}
var emailformat='^[\\w\\d\\._-]+@([\\w\\d_-]*[\\w\\d]\\.)+([\\w]{2,})$';var nombreformat='^[\\wÁÉÍÓÚÝáéíóúýäëïöüÿÄËÏÖÜàèìòùÀÈÌÒÙñÑ\\d-\\. ]*$';var formchefimage=null;function ajustarcontenedor(id,cerrado,forzado)
{if(cerrado)
{WA.toDOM(id).style.height='0px';ajustaPaginaTop(0);return;}
var h;if(forzado)
h=forzado+WA.browser.getNodeOuterHeight(WA.toDOM('header-login-cerrar'));else
h=WA.browser.getNodeOuterHeight(WA.toDOM(id).firstChild);WA.toDOM(id).style.height=h+'px';ajustaPaginaTop(h);return h;}
var pulldownopen=false;function checkPullDown()
{if(pulldownopen)
switchpulldown();}
function switchpulldown(event,mensaje)
{if(cheflogged||!chefready)
return;if(movilOpenClose=='open')
tamanochicoMenuDrop(event);if(openCloseNotif==1)
cerrarNotificaciones();if(!pulldownopen)
{switch(mensaje)
{case'listasuper':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown1");break;case'favoritos':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown2");break;case'colecciones':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown3");break;case'imprimirreceta':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown4");break;case'imprimirtip':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown5");break;case'menuplanner':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown6");break;case'recetafoto':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown7");break;case'appletv':WA.toDOM('mensaje-login').innerHTML=WA.i18n.getMessage("txtswitchpulldown8");break;default:mensaje='open';}
ajustarcontenedor('header-login-container');WA.toDOM('black-shade').className='shade-open';}
else
{ajustarcontenedor('header-login-container',true,0);WA.toDOM('black-shade').className='shade-close';WA.toDOM('mensaje-login').innerHTML='<span class="txt_bienvenida">'+WA.i18n.getMessage("txtswitchpulldown9")+'</span>, '+WA.i18n.getMessage("txtswitchpulldown10");}
pulldownopen=!pulldownopen;return WA.browser.cancelEvent(event);}
function ajustarpulldown(h)
{if(!pulldownopen)
{ajustaPaginaTop(0);return;}
ajustarcontenedor('header-login-container',false,h);}
function hideallpulldown()
{['social','conecta','login','contrasena','registro','validacodigoactivacion','enlaza','login_acckit'].forEach(function(id){ajustarcontenedor('header-login-'+id,true);});WA.toDOM('header-login-inicio').style.display='none';}
function reiniciapulldown()
{hideallpulldown();ajustarpulldown(ajustarcontenedor('header-login-social')+ajustarcontenedor('header-login-conecta'));}
var opcnativo=0;function mostrarbloque(id,registro,event)
{hideallpulldown();WA.toDOM('header-login-inicio').style.display='block';if(id=='social')
opcnativo=registro?1:0;if(id=='registro')
{if(opcnativo==1)
ajustarpulldown(ajustarcontenedor('header-login-'+id));else if(registro==2)
{opcnativo=1;ajustarpulldown(ajustarcontenedor('header-login-registro'));}
else
ajustarpulldown(ajustarcontenedor('header-login-login'));}
else
ajustarpulldown(ajustarcontenedor('header-login-'+id));switch(id)
{case'login':startlogin();break;case'contrasena':startcontrasena();break;case'validacodigoactivacion':startvalidar();break;case'registro':if(opcnativo==1)
startregistro();else if(opcnativo==0)
startlogin();break;case'enlaza':startenlaza();break;}
return WA.browser.cancelEvent(event);}
function errorlogin(id,msg)
{WA.toDOM(id).className='error-campo';WA.toDOM(id+'msg').innerHTML=msg;WA.toDOM(id+'msg').style.display='';}
function limpiacampo(id)
{WA.toDOM(id).className='';WA.toDOM(id+'msg').innerHTML='';WA.toDOM(id+'msg').style.display='none';}
var loginready=false;var loginusuario=null;var logincontrasena=null;function startlogin()
{ga('send','event','im','info/login','nativo/pc/inicio',null);try
{if(loginready)
return;loginusuario=new validator.textfield('loginusuario',{minlength:7,maxlength:250,maxwords:1,format:emailformat},'loginusuario_check',logincheckar);logincontrasena=new validator.textfield('logincontrasena',{minlength:2,maxlength:200},'logincontrasena_check',logincheckar);loginready=true;logincheckar();}
catch(e)
{ga('send','event','im','error/login','nativo/pc/1099',null);KL.manageError(e);}}
function logincheckar()
{if(!loginready)
return;try
{if(!loginusuario.status&&loginusuario.blurred)
{var usuario=WA.toDOM('loginusuario').value;if(!usuario||usuario=='')
errorlogin('loginusuario',WA.i18n.getMessage("txtlogincheckar1"));else
errorlogin('loginusuario',WA.i18n.getMessage("txtlogincheckar2"));}
else
limpiacampo('loginusuario');if(!logincontrasena.status&&logincontrasena.blurred)
{var contrasena=WA.toDOM('logincontrasena').value;if(!contrasena||contrasena=='')
errorlogin('logincontrasena',WA.i18n.getMessage("txtlogincheckar3"));else
errorlogin('logincontrasena',WA.i18n.getMessage("txtlogincheckar4"));}
else
limpiacampo('logincontrasena');ajustarpulldown(ajustarcontenedor('header-login-login'));var globalstatus=loginusuario.status&&logincontrasena.status;WA.toDOM('loginsubmit').disabled=!globalstatus;WA.toDOM('loginsubmit').value=globalstatus?WA.i18n.getMessage("txtlogincheckar5"):WA.i18n.getMessage("txtlogincheckar6");return true;}
catch(e)
{ga('send','event','im','error/login','nativo/pc/1099',null);KL.manageError(e);}}
function dologin()
{try
{var globalstatus=loginusuario.status&&logincontrasena.status;if(!globalstatus)
return;WA.toDOM('loginsubmit').disabled=true;WA.toDOM('loginsubmit').value=WA.i18n.getMessage("txtdologin");WA.toDOM('loginnativo_loading').style.display='block';var usuario=WA.toDOM('loginusuario').value;var contrasena=WA.toDOM('logincontrasena').value;var longlogin=WA.toDOM('longlogin').checked;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/login','POST',null,getlogin,false);request.addParameter('usuario',WA.UTF8.encode(usuario));request.addParameter('contrasena',WA.UTF8.encode(contrasena));request.addParameter('longlogin',longlogin?1:'');request.addParameter('device','pc');request.addParameter('ordenSeguridad','conectar');request.send();}
catch(e)
{ga('send','event','im','error/login','nativo/pc/1099',null);KL.manageError(e);}}
function reloadpage(registro)
{var disc=window.location.href.match(/desconectar/g);if(disc)
document.location.href='/';else if(registro)
{var query=window.location.href.match(/\?/g);window.location=window.location+(query?'&':'?')+'registrado=1';}
else
window.location.reload();}
function getlogin(request)
{try
{logincode=WA.JSON.decode(request.responseText);WA.toDOM('loginnativo_loading').style.display='none';if(logincode.estatus=='OK')
{ga('send','event','im','login','nativo/pc/ok',null);WA.toDOM('loginsubmit').value=WA.i18n.getMessage("txtgetlogin");setTimeout(reloadpage,100);}
else
{logincheckar();errorlogin('loginusuario',logincode.mensaje);errorlogin('logincontrasena','');WA.toDOM('loginusuario_activar').style.display=logincode.activar?'':'none';ajustarpulldown(ajustarcontenedor('header-login-login'));ga('send','event','im','error/login','nativo/pc/'+logincode.code,null);}}
catch(e)
{ga('send','event','im','error/login','nativo/pc/1099',null);KL.manageError(e);}}
var contrasenaready=false;var contrasenausuario=null;function startcontrasena()
{ga('send','event','im','info/recordar','nativo/pc/inicio',null);try
{if(contrasenaready)
return;contrasenausuario=new validator.textfield('contrasenausuario',{minlength:7,maxlength:250,maxwords:1,format:emailformat},'contrasenausuario_check',contrasenacheckar);contrasenaready=true;contrasenacheckar();}
catch(e)
{ga('send','event','im','error/recordar','nativo/pc/1499',null);KL.manageError(e);}}
function contrasenacheckar()
{if(!contrasenaready)
return;try
{if(!contrasenausuario.status&&contrasenausuario.blurred)
{var contrasena=WA.toDOM('contrasenausuario').value;if(!contrasena||contrasena=='')
errorlogin('contrasenausuario',WA.i18n.getMessage("txtcontrasenacheckar1"));else
errorlogin('contrasenausuario',WA.i18n.getMessage("txtcontrasenacheckar2"));}
else
limpiacampo('contrasenausuario');ajustarpulldown(ajustarcontenedor('header-login-contrasena'));var globalstatus=contrasenausuario.status;WA.toDOM('contrasenasubmit').disabled=!globalstatus;WA.toDOM('contrasenasubmit').value=globalstatus?WA.i18n.getMessage("txtcontrasenacheckar3"):WA.i18n.getMessage("txtcontrasenacheckar4");return true;}
catch(e)
{ga('send','event','im','error/recordar','nativo/pc/1499',null);KL.manageError(e);}}
function dorecordar()
{try
{var globalstatus=contrasenausuario.status;if(!globalstatus)
return;WA.toDOM('contrasenasubmit').disabled=true;WA.toDOM('contrasenasubmit').value=WA.i18n.getMessage("txtdorecordar");WA.toDOM('contrasenasubmit_loading').style.display='block';var usuario=WA.toDOM('contrasenausuario').value;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/recordar','POST',null,getrecordar,false);request.addParameter('usuario',WA.UTF8.encode(usuario));request.addParameter('orden','recordar');request.send();}
catch(e)
{ga('send','event','im','error/recordar','nativo/pc/1499',null);KL.manageError(e);}}
function getrecordar(request)
{try
{recordarcode=WA.JSON.decode(request.responseText);WA.toDOM('contrasenasubmit_loading').style.display='none';if(recordarcode.estatus=='OK')
{ga('send','event','im','recordar','nativo/pc/ok',null);limpiacampo('contrasenausuario');if(recordarcode.type=='contrasena')
WA.toDOM('contrasenasubmit').value=WA.i18n.getMessage("txtgetrecordar1");else
WA.toDOM('contrasenasubmit').value=WA.i18n.getMessage("txtgetrecordar2");}
else
{contrasenacheckar();errorlogin('contrasenausuario',recordarcode.mensaje);ga('send','event','im','error/recordar','nativo/pc/'+recordarcode.code,null);}
ajustarpulldown(ajustarcontenedor('header-login-contrasena'));}
catch(e)
{ga('send','event','im','error/recordar','nativo/pc/1499',null);KL.manageError(e);}}
var validarready=false;var validarcodigo=null;function startvalidar()
{ga('send','event','im','info/validar','nativo/pc/inicio',null);if(validarready)
return;try
{validarcodigo=new validator.textfield('validarcodigo',{minlength:8,maxlength:10,maxwords:1,format:'^[a-zA-Z0-9 ]{8,10}$'},'validarcodigo_check',validarcodigocheckar);validarready=true;validarcodigocheckar();}
catch(e)
{ga('send','event','im','error/validar','nativo/pc/1399',null);KL.manageError(e);}}
function validarcodigocheckar()
{if(!validarready)
return;try
{if(!validarcodigo.status&&validarcodigo.blurred)
{var validar=WA.toDOM('validarcodigo').value;if(!validar||validar=='')
errorlogin('validarcodigo',WA.i18n.getMessage("txtcontrasenacheckar1"));else
errorlogin('validarcodigo',WA.i18n.getMessage("txtcontrasenacheckar2"));}
else
limpiacampo('validarcodigo');ajustarpulldown(ajustarcontenedor('header-login-validacodigoactivacion'));var globalstatus=validarcodigo.status;WA.toDOM('validarsubmit').disabled=!globalstatus;WA.toDOM('validarsubmit').value=globalstatus?WA.i18n.getMessage("txtvalidarcodigocheckar"):WA.i18n.getMessage("txtcontrasenacheckar4");return true;}
catch(e)
{ga('send','event','im','error/validar','nativo/pc/1399',null);KL.manageError(e);}}
function dovalidar()
{try
{var globalstatus=validarcodigo.status;if(!globalstatus)
return;WA.toDOM('validarsubmit').disabled=true;WA.toDOM('validarsubmit').value=WA.i18n.getMessage("txtdovalidar");WA.toDOM('validar_loading').style.display='block';var codigo=WA.toDOM('validarcodigo').value;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/validacodigo','POST',null,getvalidar,false);request.addParameter('codigo',WA.UTF8.encode(codigo));request.addParameter('device','pc');request.addParameter('orden','validar');request.send();}
catch(e)
{ga('send','event','im','error/validar','nativo/pc/1399',null);KL.manageError(e);}}
function getvalidar(request)
{console.log('getvalidar')
try
{validarcode=WA.JSON.decode(request.responseText);WA.toDOM('validar_loading').style.display='none';if(validarcode.estatus=='REGISTRO')
{ga('send','event','im','validar','nativo/pc/ok',null);WA.toDOM('validarsubmit').value=WA.i18n.getMessage("txtgetvalidar");limpiacampo('validarcodigo');llenaRegistro(validarcode);ajustarpulldown(ajustarcontenedor('header-login-enlaza'));}
else
{validarcodigocheckar();errorlogin('validarcodigo',validarcode.mensaje);ga('send','event','im','error/validar','nativo/pc/'+validarcode.code,null);}}
catch(e)
{ga('send','event','im','error/validar','nativo/pc/1399',null);KL.manageError(e);}}
var registroready=false;var registronombre=null;var registroapellido=null;var registrousuario=null;var registrocontrasena=null;var registrocontrasena2=null;var registronewsletter=null;var registropoliticas=null;function startregistro()
{ga('send','event','im','info/registro','nativo/pc/inicio',null);if(registroready)
return;try
{registronombre=new validator.textfield('registronombre',{minlength:2,maxlength:50,maxwords:5,format:nombreformat},'registronombre_check',registrocheckar);registroapellido=new validator.textfield('registroapellido',{minlength:2,maxlength:50,maxwords:5,format:nombreformat},'registroapellido_check',registrocheckar);registrousuario=new validator.textfield('registrousuario',{maxlength:250,format:emailformat},'registrousuario_check',registrocheckar);registrocontrasena=new validator.textfield('registrocontrasena',{minlength:6,maxlength:200},'registrocontrasena_check',strong);registrocontrasena2=new validator.textfield('registrocontrasena2',{minlength:6,maxlength:200},'registrocontrasena2_check',pswmatch);registronewsletter=new validator.checkboxfield('registronewsletter',{},null,null);registropoliticas=new validator.checkboxfield('registropoliticas',{notempty:true},null,registrocheckar);registroready=true;registrocheckar();}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
function registrocheckar()
{if(!registroready)
return;try
{if(!registronombre.status&&registronombre.blurred)
{var nombre=WA.toDOM('registronombre').value;if(!nombre||nombre=='')
errorlogin('registronombre',WA.i18n.getMessage("txtpventa15"));else
errorlogin('registronombre',WA.i18n.getMessage("txtpventa16"));}
else
limpiacampo('registronombre');if(!registroapellido.status&&registroapellido.blurred)
{var apellido=WA.toDOM('registroapellido').value;if(!apellido||apellido=='')
errorlogin('registroapellido',WA.i18n.getMessage("txtregistrocheckar5"));else
errorlogin('registroapellido',WA.i18n.getMessage("txtpventa16"));}
else
limpiacampo('registroapellido');if(!registrousuario.status&&registrousuario.blurred)
{var usuario=WA.toDOM('registrousuario').value;if(!usuario||usuario=='')
errorlogin('registrousuario',WA.i18n.getMessage("txtcontrasenacheckar1"));else
errorlogin('registrousuario',WA.i18n.getMessage("txtcontrasenacheckar2"));}
else
limpiacampo('registrousuario');if(!registrocontrasena.status&&registrocontrasena.blurred)
{var contrasena=WA.toDOM('registrocontrasena').value;if(!contrasena||contrasena=='')
errorlogin('registrocontrasena',WA.i18n.getMessage("txtlogincheckar3"));else
errorlogin('registrocontrasena',WA.i18n.getMessage("txtlogincheckar4"));}
else
limpiacampo('registrocontrasena');if(!registrocontrasena2.status&&registrocontrasena2.blurred)
{var contrasena2=WA.toDOM('registrocontrasena2').value;if(!contrasena2||contrasena2=='')
errorlogin('registrocontrasena2',WA.i18n.getMessage("txtregistrocheckar1"));else
errorlogin('registrocontrasena2',WA.i18n.getMessage("txtregistrocheckar2"));}
else
limpiacampo('registrocontrasena2');if(!registropoliticas.status&&registropoliticas.blurred)
{var politicas=WA.toDOM('registropoliticas').checked;if(!politicas)
errorlogin('registropoliticas',WA.i18n.getMessage("txtregistrocheckar3"));}
else
limpiacampo('registropoliticas');ajustarpulldown(ajustarcontenedor('header-login-registro'));var globalstatus=registronombre.status&&registroapellido.status&&registrousuario.status&&registrocontrasena.status&&registrocontrasena2.status&&registropoliticas.status;WA.toDOM('registrosubmit').disabled=!globalstatus;WA.toDOM('registrosubmit').value=globalstatus?WA.i18n.getMessage("txtregistrocheckar4"):WA.i18n.getMessage("txtcontrasenacheckar4");return true;}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
function strong()
{try
{var ok=0;var psw=WA.toDOM('registrocontrasena').value;if(psw.match(/[A-Z]/))ok++;if(psw.match(/[a-z]/))ok++;if(psw.match(/[0-9]/))ok++;if(psw.match(/[@#$%&!*)(-+=^]/))ok++;if(psw==""||psw.length<6)
{WA.toDOM('registrocontrasena_fuerza').style.color='#faa';WA.toDOM('registrocontrasena_fuerza').innerHTML=WA.i18n.getMessage("txtstrong1");WA.toDOM('registrocontrasena_fuerzavisual').style.width='25%';WA.toDOM('registrocontrasena_fuerzavisual').style.backgroundColor='#f66';}
else if(ok<=2)
{WA.toDOM('registrocontrasena_fuerza').style.color='#fa0';WA.toDOM('registrocontrasena_fuerza').innerHTML=WA.i18n.getMessage("txtstrong2");WA.toDOM('registrocontrasena_fuerzavisual').style.width='50%';WA.toDOM('registrocontrasena_fuerzavisual').style.backgroundColor='#fa0';}
else if(ok==3)
{WA.toDOM('registrocontrasena_fuerza').style.color='blue';WA.toDOM('registrocontrasena_fuerza').innerHTML=WA.i18n.getMessage("txtstrong3");WA.toDOM('registrocontrasena_fuerzavisual').style.width='75%';WA.toDOM('registrocontrasena_fuerzavisual').style.backgroundColor='blue';}
else if(ok==4)
{WA.toDOM('registrocontrasena_fuerza').style.color='#afa';WA.toDOM('registrocontrasena_fuerza').innerHTML=WA.i18n.getMessage("txtstrong4");WA.toDOM('registrocontrasena_fuerzavisual').style.width='100%';WA.toDOM('registrocontrasena_fuerzavisual').style.backgroundColor='#6f6';}
registrocheckar();}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
function pswmatch()
{try
{registrocheckar();if(registrocontrasena.status&&registrocontrasena2.status)
{var psw=WA.toDOM('registrocontrasena').value;var psw2=WA.toDOM('registrocontrasena2').value;if(psw&&psw2&&psw!=psw2)
errorlogin('registrocontrasena2',WA.i18n.getMessage("txtpswmatch"));else
limpiacampo('registrocontrasena2');}}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
function checkmail()
{if(!registrousuario.status)
return;var mail=WA.toDOM('registrousuario').value;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/validacorreo','POST',"usuario="+mail,validamail,true);}
function validamail(request)
{try
{var data=WA.JSON.decode(request.responseText);var codigo=data.code;var txt='';if(codigo==1101)
{txt=WA.i18n.getMessage("txtvalidamailsocial1")+' <div class="tinylink" style="text-align: right; margin-top: 5px;" onclick="mostrarbloque(\'contrasena\');">'+WA.i18n.getMessage("txtvalidamailsocial2")+'.</div> <div class="tinylink" style="text-align: right; margin-top: 5px;" onclick="reiniciapulldown();">'+WA.i18n.getMessage("txtvalidamail3")+'.</div>';}
else if(codigo==1102)
{txt=WA.i18n.getMessage("txtvalidamailsocial3");}
else if(codigo==1103)
{txt=WA.i18n.getMessage("txtvalidamailsocial4");}
if(codigo)
{ga('send','event','im','error/registro','correo/pc/'+codigo,null);registrousuario.forceerror();errorlogin('registrousuario',txt);}
else
{limpiacampo('registrousuario');}}
catch(e)
{ga('send','event','im','error/registro','correo/pc/1199',null);KL.manageError(e);}}
function doregistro()
{try
{var globalstatus=registronombre.status&&registroapellido.status&&registrousuario.status&&registrocontrasena.status&&registrocontrasena2.status&&registropoliticas.status;if(!globalstatus)
return;WA.toDOM('registrosubmit').disabled=true;WA.toDOM('registrosubmit').value=WA.i18n.getMessage("txtdoregistro");WA.toDOM('registronativo_loading').style.display='block';var nombre=WA.toDOM('registronombre').value;var apellido=WA.toDOM('registroapellido').value;var usuario=WA.toDOM('registrousuario').value;var contrasena=WA.toDOM('registrocontrasena').value;var contrasena2=WA.toDOM('registrocontrasena2').value;var newsletter=WA.toDOM('registronewsletter').checked;var politicas=WA.toDOM('registropoliticas').checked;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/registro','POST',null,getregistro,false);request.addParameter('nombre',WA.UTF8.encode(nombre));request.addParameter('apellido',WA.UTF8.encode(apellido));request.addParameter('usuario',WA.UTF8.encode(usuario));request.addParameter('contrasena',WA.UTF8.encode(contrasena));request.addParameter('contrasena2',WA.UTF8.encode(contrasena2));request.addParameter('newsletter',newsletter?1:0);request.addParameter('politicas',politicas);request.addParameter('orden','registrar');request.send();}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
function getregistro(request)
{try
{var registrocode=WA.JSON.decode(request.responseText);WA.toDOM('registronativo_loading').style.display='none';if(registrocode.estatus=='REGISTRO')
{ga('send','event','im','registro','nativo/pc/ok',null);mostrarbloque('validacodigoactivacion');}
else
{if(registrocode.tipo=='correo')
{validamail({responseText:"{code: "+registrocode.codigo+"}"});}
else
errorlogin('registro'+registrocode.tipo,registrocode.mensaje);ajustarpulldown(ajustarcontenedor('header-login-registro'));ga('send','event','im','error/registro','nativo/pc/'+registrocode.code,null);}}
catch(e)
{ga('send','event','im','error/registro','nativo/pc/1299',null);KL.manageError(e);}}
var enlazaready=false;var loginusuariosocial=null;var logincontrasenasocial=null;var registronombresocial=null;var registroapellidosocial=null;var registrousuariosocial=null;function startenlaza()
{if(enlazaready)
return;try
{registronombresocial=new validator.textfield('registronombresocial',{minlength:2,maxlength:50,maxwords:5,format:nombreformat},'registronombresocial_check',registrosocialcheckar);registroapellidosocial=new validator.textfield('registroapellidosocial',{minlength:0,maxlength:50,maxwords:5,format:nombreformat},'registroapellidosocial_check',registrosocialcheckar);registrousuariosocial=new validator.textfield('registrousuariosocial',{minlength:0,maxlength:50,maxwords:1,format:emailformat},'registrousuariosocial_check',registrosocialcheckar);enlazaready=true;registrosocialcheckar();}
catch(e)
{ga('send','event','im','error/registrosocial','social/pc/1799',null);KL.manageError(e);}}
function registrosocialcheckar()
{if(!enlazaready)
return;try
{if(!registronombresocial.status&&registronombresocial.blurred)
{var nombre=WA.toDOM('registronombresocial').value;if(!nombre||nombre=='')
errorlogin('registronombresocial',WA.i18n.getMessage("txtpventa15"));else
errorlogin('registronombresocial',WA.i18n.getMessage("txtregistrosocialcheckar1"));}
else
limpiacampo('registronombresocial');if(!registroapellidosocial.status&&registroapellidosocial.blurred)
{var apellido=WA.toDOM('registroapellidosocial').value;if(!apellido||apellido=='')
{}
else
errorlogin('registroapellidosocial',WA.i18n.getMessage("txtregistrosocialcheckar2"));}
else
limpiacampo('registroapellidosocial');if(!registrousuariosocial.status&&registrousuariosocial.blurred)
{var usuario=WA.toDOM('registrousuariosocial').value;if(!usuario||usuario=='')
{}
else
errorlogin('registrousuariosocial',WA.i18n.getMessage("txtcontrasenacheckar2"));}
else
limpiacampo('registrousuariosocial');ajustarpulldown(ajustarcontenedor('header-login-enlaza'));var globalstatus=registronombresocial.status&&registroapellidosocial.status&&registrousuariosocial.status;WA.toDOM('registrosocialsubmit').disabled=!globalstatus;WA.toDOM('registrosocialsubmit').value=globalstatus?WA.i18n.getMessage("txtregistrosocialcheckar3"):WA.i18n.getMessage("txtcontrasenacheckar4");return true;}
catch(e)
{ga('send','event','im','error/registrosocial','social/pc/1799',null);KL.manageError(e);}}
function checkmailsocial()
{if(!registrousuariosocial.status)
return;var mail=WA.toDOM('registrousuariosocial').value;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/validacorreo','POST',"social=1&usuario="+mail,validamailsocial,true);}
function validamailsocial(request)
{try
{var data=WA.JSON.decode(request.responseText);var codigo=data.code;var txt='';if(codigo==1101)
{txt=WA.i18n.getMessage("txtvalidamail1")+' <div class="tinylink" style="text-align: right; margin-top: 5px;" onclick="mostrarbloque(\'contrasena\');">'+WA.i18n.getMessage("txtvalidamailsocial2")+'.</div>';}
else if(codigo==1102)
{txt=WA.i18n.getMessage("txtvalidamailsocial3");}
else if(codigo==1103)
{txt=WA.i18n.getMessage("txtvalidamailsocial4");}
if(codigo)
{ga('send','event','im','error/registrosocial','correo/pc/'+codigo,null);registrousuariosocial.forceerror();errorlogin('registrousuariosocial',txt);}
else
{limpiacampo('registrousuariosocial');}}
catch(e)
{ga('send','event','im','error/registrosocial','correo/pc/1199',null);KL.manageError(e);}}
function doenlaceregistro()
{try
{var globalstatus=registronombresocial.status&&registroapellidosocial.status&&registrousuariosocial.status;if(!globalstatus)
return;WA.toDOM('registrosocialsubmit').disabled=true;WA.toDOM('registrosocialsubmit').value=WA.i18n.getMessage("txtdoenlaceregistro");var redsocial=WA.toDOM('registroredsocial').value;var GUID=WA.toDOM('registroguidsocial').value;var avatar=WA.toDOM('registroimagensocial').value;var nombre=WA.toDOM('registronombresocial').value;var apellido=WA.toDOM('registroapellidosocial').value;var usuario=WA.toDOM('registrousuariosocial').value;var newsletter=WA.toDOM('registronewslettersocial').checked;var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/actualizar','POST',null,getenlazarregistro,false);request.addParameter('redsocial',redsocial);request.addParameter('GUID',GUID);if(avatar)
request.addParameter('avatar',avatar);if(redsocial=='fb')
{var fb=KL.Modules.facebook.getObject();if(fb&&fb.authResponse)
request.addParameter('object',WA.JSON.encode(fb.authResponse));}
if(redsocial=='google')
{var googletoken=KL.Modules.googleplus.getObject();if(googletoken)
request.addParameter('object',WA.JSON.encode(googletoken));}
if(redsocial=='acckit')
{var acckittoken=KL.Modules.accountkit.getObject();if(acckittoken)
request.addParameter('object',WA.JSON.encode(acckittoken));}
request.addParameter('usuario',usuario);request.addParameter('nombre',nombre);request.addParameter('apellido',apellido);request.addParameter('newsletter',newsletter?1:0);request.send();}
catch(e)
{ga('send','event','im','error/registrosocial','social/pc/1799',null);KL.manageError(e);}}
function getenlazarregistro(request)
{console.log('getenlazarregistro')
try
{enlazarcode=WA.JSON.decode(request.responseText);if(enlazarcode.estatus=='OK')
{ga('send','event','im','registrosocial',enlazarcode.redsocial+'/pc/ok',null);WA.toDOM('loginsubmit').value=WA.i18n.getMessage("txtdoenlaceregistro");setTimeout(function(){if(enlazarcode.hasOwnProperty('accion')&&enlazarcode.accion===1)
mostrarbloque('validacodigoactivacion');else
reloadpage(true);},100);}
else
{ga('send','event','im','error/registrosocial',enlazarcode.redsocial+'/pc/'+enlazarcode.code,null);registrosocialcheckar();if(enlazarcode.tipo=='correo')
{validamailsocial({responseText:enlazarcode.codigo});}
else
errorlogin('registro'+enlazarcode.tipo+'social',enlazarcode.mensaje);}
ajustarpulldown(ajustarcontenedor('header-login-enlaza'));}
catch(e)
{ga('send','event','im','error/registrosocial','social/pc/1799',null);KL.manageError(e);}}
function subeimagenusuario(tipo,event)
{formChefImage();WA.toDOM('pagecontainer').style.position='fixed';KL.popup.show('subir-imagen-chef');}
function formChefImage()
{formchefimage=new ajaximage('subirFotoChef','IMAGENCHEF');formchefimage.setLoadingImage(KL.cdndomains+'/kiwi5/static/loading.gif');formchefimage.setAction('/listeners/dochefimagen?orden=fotochef');formchefimage.setPage('foto');}
var enviandoimagen=false;function enviarchefimagen()
{if(!cancelarimg)
{var campo_valida_imagen=WA.toDOM('IMAGENCHEF_file').value;if(campo_valida_imagen.length>0)
{WA.toDOM('validaChefImagen').innerHTML=WA.i18n.getMessage("txtenviarchefimagen2");enviandoimagen=true;var imagen=WA.toDOM('IMAGENCHEF').value;var orden=WA.toDOM('ordenchef').value;var imagenfile=WA.toDOM('IMAGENCHEF_file').value;WA.toDOM('registroimagensocial').value=imagenfile;var imagendownload=WA.toDOM('IMAGENCHEF_download').value;var preview=WA.toDOM('IMAGENCHEF_image').src;WA.toDOM('socialenlazarfoto').style.backgroundImage="url("+preview+")";WA.toDOM('socialenlazarfoto').style.backgroundSize="cover";KL.popup.hide();}
else
{alerta(WA.i18n.getMessage("txtenviarimagen2"));}}
else
alerta(WA.i18n.getMessage("txtenviarchefimagen4"));}
function imagenrespuestachef(response)
{var preview=WA.toDOM('IMAGENCHEF_image').src;if(response.statusText='OK')
{WA.toDOM('socialenlazarfoto').style.backgroundImage="url("+preview+")";WA.toDOM('socialenlazarfoto').style.backgroundSize="cover";alerta(response.responseText);}
else
alerta(WA.i18n.getMessage("txtimagenrespuestachef")+response.responseText);}
function cerrarSubirfotochef()
{WA.toDOM('IMAGENCHEF').value='';WA.toDOM('ordenchef').value='';WA.toDOM('IMAGENCHEF_file').value='';WA.toDOM('IMAGENCHEF_download').value='';WA.toDOM('IMAGENCHEF_image').src='';WA.toDOM('IMAGENCHEF_image').style.width='0px';WA.toDOM('validaChefImagen').innerHTML=WA.i18n.getMessage("txtcerrarSubirfotochef");}
var cancelarimg=false;this.cancelarsubidaimgchef=cancelarsubidaimgchef;function cancelarsubidaimgchef()
{cancelarimg=true;cerrarSubirfotochef();WA.toDOM('pagecontainer').style.position='';KL.popup.hide();}
function verificaNotificacion(notif)
{notificaciones=notif;if(notif&&notif.notif&&notif.notif>0)
{WA.toDOM('notif-salta').innerHTML=notif.notif;WA.toDOM('notif-salta').style.display='block';WA.toDOM('notif-salta-menu').innerHTML=notif.notif;WA.toDOM('notif-salta-menu').style.display='inline';}
else
{WA.toDOM('notif-salta').style.display='none';WA.toDOM('notif-salta-menu').style.display='none';}}
var numsalta=0;function setNodes(notif,z)
{var node=WA.createDomNode('div','notif|'+notif.gen[z].id,'notificacion');if(notif.gen[z].imagen)
node.innerHTML='<a class="link-notif" href="'+notif.gen[z].liga+'"><div class="notif-left"><img src="'+KL.cdndomain+'/recetaimagen/'+notif.gen[z].rec+'/'+notif.gen[z].imagen+'" alt="" title="" /></div><div class="notif-right"><p>'+notif.gen[z].titulo+'</p><div class="timelapse" id="notif|'+notif.gen[z].id+'_timelapse"></div></div></a>';else
node.innerHTML='<a class="link-notif" href="'+notif.gen[z].liga+'"><div class="notif-left"><img src="'+KL.cdndomain+'/img/static/logo-o-90.png" alt="" title="" /></div><div class="notif-right"><p>'+notif.gen[z].titulo+'</p><div class="timelapse" id="notif|'+notif.gen[z].id+'_timelapse"></div></div></a>';if(z==notif.gen.length-1)
WA.toDOM('notif-data-lista').appendChild(node);else
{WA.toDOM('notif-data-lista').insertBefore(node,WA.toDOM('notif|'+notif.gen[z+1].id))}
if(chefcode.chef)
{if(chefcode.chef.ultimaconsulta<=notif.gen[z].fechaNot)
{numsalta=numsalta+1;WA.toDOM('notif-salta').style.display='block';}}
else
{var tmpTa=parseInt(ta);if(isNaN(tmpTa)||tmpTa<=parseInt(notif.gen[z].fechaNot*1000))
{WA.toDOM('notif-salta').style.display='block';numsalta=numsalta+1;}}}
function consultaNotif(up)
{var request=WA.Managers.ajax.createRequest('/listeners/getchef','POST','getnotif=1&update='+up,getConsultaNotif,true);}
function getConsultaNotif()
{WA.toDOM('notif-salta').style.display='none';}
var openCloseNotif=0;var invalidEvent=0;function abrirCerrar(event)
{if(openCloseNotif==0)
{setTimeout(function(){openCloseNotif=1},0);openCloseNotif=2;var h=WA.browser.getNodeHeight(WA.toDOM('notif-data'));WA.toDOM('notif-data-container').style.height=h+'px';WA.toDOM('notif-salta').style.display='none';WA.toDOM('arrowOpenClose').className='close-arrow';WA.toDOM('header-usuario').className='on';KL.setCookie('tsnotifglobal',new Date().getTime(),365);consultaNotif('update');numsalta=0;ga('send','event','menus','men/notificaciones','men/not/abrir',null);}
else if(openCloseNotif==1)
{cerrarNotificaciones();}}
function cerrarNotificaciones()
{if(openCloseNotif==0)
return;if(invalidEvent==1)
{invalidEvent=0;return;}
if(openCloseNotif==1)
{openCloseNotif=0;WA.toDOM('notif-data-container').style.height='0px';WA.toDOM('arrowOpenClose').className='open-arrow';WA.toDOM('header-usuario').className='';ga('send','event','menus','men/notificaciones','men/not/cerrar',null);}}
function invalidClose()
{invalidEvent=1;}
function setTimes(notif,z)
{var tiempoTranscurrido=(new Date().getTime()-(notif.gen[z].fechaNot*1000))-chefDeltaTime;var cuantoTiempo=null;var tiempoExacto=null;if(tiempoTranscurrido<=60000)
{WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif1");}
else if(tiempoTranscurrido<=3600000)
{tiempoExacto=(tiempoTranscurrido/60000)
WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif2")+' : '+((parseInt(tiempoExacto)==1)?parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif3"):parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif4"));}
else if(tiempoTranscurrido<=86400000)
{tiempoExacto=(tiempoTranscurrido/3600000)
WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif2")+' : '+((parseInt(tiempoExacto)==1)?parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif5"):parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif6"));}
else if(tiempoTranscurrido<=2592000000)
{tiempoExacto=(tiempoTranscurrido/86400000)
WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif2")+' : '+((parseInt(tiempoExacto)==1)?parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif7"):parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif8"));}
else if(tiempoTranscurrido<=31104000000)
{tiempoExacto=(tiempoTranscurrido/2592000000)
WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif2")+' : '+((parseInt(tiempoExacto)==1)?parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif9"):parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif10"));}
else
{tiempoExacto=(tiempoTranscurrido/31104000000)
WA.toDOM('notif|'+notif.gen[z].id+'_timelapse').innerHTML=WA.i18n.getMessage("txtnotif2")+' : '+((parseInt(tiempoExacto)==1)?parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif11"):parseInt(tiempoExacto)+' '+WA.i18n.getMessage("txtnotif12"));}}
function seguirChef(chef)
{var request=WA.Managers.ajax.createRequest('/listeners/doaction','POST','orden=seguirchef&chef='+chef,seguirChefRespuesta,true);}
function seguirChefRespuesta(request)
{if(request.responseText.trim()=='OK')
{WA.toDOM('chef-no').style.display='none';WA.toDOM('chef-si').style.display='block';}}
var tmpScrollPosition=null;function scrollfooter(e)
{return;var documentheight=WA.browser.getDocumentHeight();var windowheight=WA.browser.getWindowHeight();var scrollpos=WA.browser.getScrollTop();if(tmpScrollPosition<=scrollpos&&tamanochico)
{WA.toDOM('footer').style.bottom='-188px ';}
else
{WA.toDOM('footer').style.bottom='-148px';}
tmpScrollPosition=scrollpos;if(scrollpos>documentheight-windowheight-50)
{WA.toDOM('footer').style.bottom='0';WA.toDOM('activar_footer').className='up';WA.toDOM('activar_footer').style.opacity=0;}
else
{WA.toDOM('activar_footer').className='';WA.toDOM('activar_footer').style.opacity=1;}}
function mostrar_footer()
{if(WA.toDOM('footer').style.bottom=='-148px')
{WA.toDOM('footer').style.bottom='0';WA.toDOM('activar_footer').className='up';}
else
{WA.toDOM('footer').style.bottom='-148px';WA.toDOM('activar_footer').className='';}}
window.onscroll=apa;function apa()
{var scrollpos=WA.browser.getScrollTop();if(WA.toDOM('inicio_footer'))
{if(scrollpos>=300)
{WA.toDOM('inicio_footer').style.opacity=1;}
else if(scrollpos<=300)
{WA.toDOM('inicio_footer').style.opacity=0;}}}
var stepTime=20;var focElem=document.documentElement;var scrollAnimationStep=function(initPos,stepAmount)
{var newPos=initPos-stepAmount>0?initPos-stepAmount:0;document.body.scrollTop=focElem.scrollTop=newPos;newPos&&setTimeout(function(){scrollAnimationStep(newPos,stepAmount);},stepTime);}
var scrollTopAnimated=function(speed)
{var topOffset=document.body.scrollTop||focElem.scrollTop;var stepAmount=topOffset;speed&&(stepAmount=(topOffset*stepTime)/speed);scrollAnimationStep(topOffset,stepAmount);};KL.galerias=new function()
{var self=this;this.galerias=[];this.sliders=[];this.sliderspublicidad=null;this.start=start;function start()
{var galeriaNodes=document.getElementsByClassName('galeria');if(galeriaNodes)
{for(var i=0;i<galeriaNodes.length;i++)
{var existe=false;for(var j=0;j<self.galerias.length;j++)
{if(self.galerias[j].node==galeriaNodes[i])
{existe=true;break;}}
if(!existe)
self.galerias.push(new KL.galerias.galeria(galeriaNodes[i]));}}
var sliderNodes=document.getElementsByClassName('slider');if(sliderNodes)
{for(var i=0;i<sliderNodes.length;i++)
{self.sliders[i]=new KL.galerias.slider(sliderNodes[i]);}}
if(WA.toDOM('layer-publicidad'))
{self.sliderspublicidad=new KL.galerias.sliderpublicidad();}}
this.adjustad=adjustad;function adjustad()
{if(self.sliderspublicidad)
self.sliderspublicidad.adjust();}
this.getgaleria=getgaleria;function getgaleria(id)
{for(var j=0;j<self.galerias.length;j++)
{if(self.galerias[j].node.id==id)
{return self.galerias[j];}}
return null;}}
KL.galerias.galeria=function(node)
{var self=this;this.node=node;this.playing=false;this.timing=5000;this.timer=null;this.started=false;this.dragged=false;function setNodeClasses(current,next)
{var before=true;for(var i=0,l=self.container.childNodes.length;i<l;i++)
{if(self.container.childNodes[i]==current)
{self.container.childNodes[i].className='galeria-off '+self.animation+(before?' before':' after')+' anim';}
else if(self.container.childNodes[i]==next)
{self.container.childNodes[i].className='galeria-on '+self.animation;before=false;}
else
{self.container.childNodes[i].className='galeria-off '+self.animation+(before?' before':' after');}}}
function keyleft(e,key,type)
{if(type=='up')
clickleft();}
this.clickleft=clickleft;function clickleft(event)
{if(self.timer)
{clearTimeout(self.timer);self.timer=setTimeout(clickrun,self.timing);}
if(self.current.previousSibling)
var nextone=self.current.previousSibling;else
{if(!self.withedges)
var nextone=self.container.lastChild;else
return;}
setNodeClasses(self.current,nextone);self.current=nextone;self.left.className='galeria-button galeria-left'+(self.withedges&&!self.current.previousSibling?' off':'');self.right.className='galeria-button galeria-right'+(self.withedges&&!self.current.nextSibling?' off':'');if(self.withbullets)
{if(self.bulletcurrent.previousSibling)
var nextbone=self.bulletcurrent.previousSibling;else
var nextbone=self.bulletscontainer.lastChild;nextbone.className='galeria-bullet on';self.bulletcurrent.className='galeria-bullet';self.bulletcurrent=nextbone;movebulletbar();}
ga('send','event','pagina','pag/galeria','pag/gal/click-left',null);}
function keyright(e,key,type)
{if(type=='up')
clickright();}
this.clickright=clickright;function clickright(event,noevent)
{if(self.timer)
{clearTimeout(self.timer);self.timer=setTimeout(clickrun,self.timing);}
if(self.current.nextSibling)
var nextone=self.current.nextSibling;else
{if(!self.withedges)
var nextone=self.container.firstChild;else
return;}
setNodeClasses(self.current,nextone);self.current=nextone;self.left.className='galeria-button galeria-left'+(self.withedges&&!self.current.previousSibling?' off':'');self.right.className='galeria-button galeria-right'+(self.withedges&&!self.current.nextSibling?' off':'');if(self.withbullets)
{if(self.bulletcurrent.nextSibling)
var nextbone=self.bulletcurrent.nextSibling;else
var nextbone=self.bulletscontainer.firstChild;nextbone.className='galeria-bullet on';self.bulletcurrent.className='galeria-bullet';self.bulletcurrent=nextbone;movebulletbar();}
if(noevent!=true)
ga('send','event','pagina','pag/galeria','pag/gal/click-right',null);}
function clickrun()
{if(self.timer)
self.timer=null;if(self.playing)
{self.timer=setTimeout(clickrun,self.timing);}
clickright(null,true);}
function clickplay(event,noevent)
{if(self.playing)
{clearTimeout(self.timer);self.timer=null;self.playing=false;self.play.className='galeria-button galeria-playeroff';ga('send','event','pagina','pag/galeria','pag/gal/click-stop',null);}
else
{self.timer=setTimeout(clickrun,self.timing);self.playing=true;self.play.className='galeria-button galeria-playeron';if(noevent!=true)
ga('send','event','pagina','pag/galeria','pag/gal/click-start',null);}}
function gotoslide()
{if(self.timer)
{clearTimeout(self.timer);self.timer=setTimeout(clickrun,self.timing);}
if(this.linked!=self.current)
{var nextone=this.linked;setNodeClasses(self.current,nextone);self.current=this.linked;if(self.withbullets)
{var nextbone=this;nextbone.className='galeria-bullet on';self.bulletcurrent.className='galeria-bullet';self.bulletcurrent=nextbone;movebulletbar();}}
if(self.withedges)
{self.left.className='galeria-button galeria-left'+(self.withedges&&!self.current.previousSibling?' off':'');self.right.className='galeria-button galeria-right'+(self.withedges&&!self.current.nextSibling?' off':'');}
ga('send','event','pagina','pag/galeria','pag/gal/click-goto',null);}
function getsize()
{var width=0;for(var i=0,l=self.bulletscontainer.childNodes.length;i<l;i++)
{if(self.bulletscontainer.childNodes[i].nodeType!=1)
continue;var x=WA.browser.getNodeNodeLeft(self.bulletscontainer.childNodes[i],self.bulletscontainer)+WA.browser.getNodeOuterWidth(self.bulletscontainer.childNodes[i]);if(x>width)
width=x;}
return width;}
function movebulletbar()
{var left=WA.browser.getNodeNodeLeft(self.bulletcurrent,self.bulletscontainer);var widthbullet=WA.browser.getNodeOuterWidth(self.bulletcurrent);var fullcenter=left+Math.floor(widthbullet/2);var fullwidth=getsize();var width=WA.browser.getNodeOuterWidth(self.bullets);if(fullwidth<width)
var pos=(width-fullwidth)/2;else
{var pos=width/2-fullcenter;if(pos>0)
pos=0;if(pos<(width-fullwidth>0?0:width-fullwidth))
pos=(width-fullwidth>0?0:width-fullwidth);}}
function buildBullets()
{for(var i=0,l=self.container.childNodes.length;i<l;i++)
{var bNode=self.container.childNodes[i].getElementsByClassName('galeria-bullet');if(bNode)
{for(var j=0;j<bNode.length;j++)
{bNode[j].linked=self.container.childNodes[i];bNode[j].onclick=gotoslide;self.bulletscontainer.appendChild(bNode[j]);}}}}
function listener(type,metrics)
{if(type=='right')
{clickright();}
if(type=='left')
{clickleft();}
return true;}
this.restart=restart;function restart()
{gotoslide.call(self.bulletscontainer.firstChild);}
this.stop=stop;function stop()
{if(self.playing)
{clearTimeout(self.timer);self.timer=null;self.playing=false;self.play.className='galeria-button galeria-playeroff';ga('send','event','pagina','pag/galeria','pag/gal/click-stop',null);}}
this.animation='fade';if(this.node.getAttribute("animation"))
{this.animation=this.node.getAttribute("animation");}
this.withedges=false;if(this.node.getAttribute("edges")=='yes')
{this.withedges=true;}
this.container=WA.createDomNode('div',this.node.id?this.node.id+'_container':null,'galeria-container');while(this.node.hasChildNodes())
{if(this.node.firstChild.nodeType==1)
{this.node.firstChild.className='galeria-off '+this.animation+' after';this.node.firstChild.style.display='block';this.container.appendChild(this.node.firstChild);}
else
this.node.removeChild(this.node.firstChild);}
this.node.appendChild(this.container);KL.touchslider.startzone(this.container,listener);this.container.firstChild.className='galeria-on '+this.animation;this.current=this.container.firstChild;var h=WA.browser.getNodeOuterHeight(this.current);if(h<20)
h=WA.browser.getNodeOuterHeight(this.current.firstChild);this.container.style.height=h+'px';this.left=WA.createDomNode('div',null,'galeria-button galeria-left'+(this.withedges&&!this.current.previousSibling?' off':''));this.node.appendChild(this.left);this.left.onclick=clickleft;this.right=WA.createDomNode('div',null,'galeria-button galeria-right'+(this.withedges&&!this.current.nextSibling?' off':''));this.node.appendChild(this.right);this.right.onclick=clickright;this.play=WA.createDomNode('div',null,'galeria-button galeria-playeroff');this.node.appendChild(this.play);this.play.onclick=clickplay;this.withbullets=false;if(this.node.getAttribute("bullets")=='yes')
{this.withbullets=true;this.bullets=WA.createDomNode('div',null,'galeria-bullets');this.node.appendChild(this.bullets);this.bulletscontainer=WA.createDomNode('div',null,'galeria-bullets-container');this.bullets.appendChild(this.bulletscontainer);buildBullets();this.bulletcurrent=this.bulletscontainer.firstChild;this.bulletcurrent.className='galeria-bullet on';movebulletbar();WA.Managers.event.on('resize',window,movebulletbar,true);}
if(this.node.getAttribute("time"))
{this.timing=parseInt(this.node.getAttribute("time"),10);}
this.withkeys=false;if(this.node.getAttribute("keyboard")=='yes')
{this.withkeys=true;WA.Managers.event.key('left',keyleft);WA.Managers.event.key('right',keyright);}
if(this.node.getAttribute("autostart")=='yes')
{clickplay(null,true);}}
KL.galerias.slider=function(node)
{var self=this;this.node=node;this.position=0;this.positionstart=0;this.started=false;this.dragged=false;this.percentmove=1;function clickleft(event)
{var width=WA.browser.getNodeWidth(self.node);self.position+=Math.round(width*self.percentmove);if(self.position>0)
self.position=0;self.container.style.left=self.position+'px';ga('send','event','pagina','pag/slider','pag/sli/click-left',null);}
function clickright(event)
{var width=WA.browser.getNodeWidth(self.node);self.position-=Math.round(width*self.percentmove);var size=getsize();var min=-size+width;if(min>0)
min=0;if(self.position<min)
self.position=min;self.container.style.left=self.position+'px';ga('send','event','pagina','pag/slider','pag/sli/click-right',null);}
function getsize()
{var width=0;for(var i=0,l=self.container.childNodes.length;i<l;i++)
{if(self.container.childNodes[i].nodeType!=1)
continue;var x=WA.browser.getNodeNodeLeft(self.container.childNodes[i],self.container)+WA.browser.getNodeOuterWidth(self.container.childNodes[i]);if(x>width)
width=x;}
return width;}
function listener(type,metrics)
{if(type=='start')
{self.container.className='slider-container noanim';self.positionstart=self.position;self.dragged=false;self.started=true;return true;}
if(type=='drag')
{if(!self.started||Math.abs(metrics.dx)<10)
return true;self.dragged=true;self.position=self.positionstart-metrics.dx;var width=WA.browser.getNodeWidth(self.node);if(self.position>0)
self.position=0;var size=getsize();var min=-size+width;if(min>0)
min=0;if(self.position<min)
self.position=min;self.container.style.left=self.position+'px';return false;}
if(type=='release')
{self.container.className='slider-container';if(self.dragged)
{self.started=false;self.dragged=false;return false;}
return true;}}
for(var i=0,l=this.node.childNodes.length;i<l;i++)
{if(this.node.childNodes[i].className=='slider-container')
{this.container=this.node.childNodes[i];}}
KL.touchslider.startzone(this.container,listener);if(this.node.getAttribute("buttons")=='outside')
{this.buttonsoutside=true;}
if(this.node.getAttribute("percentmove"))
{this.percentmove=parseFloat(this.node.getAttribute("percentmove"));}
this.left=WA.createDomNode('div',null,'slider-button slider-left');if(this.buttonsoutside)
this.node.parentNode.appendChild(this.left);else
this.node.appendChild(this.left);this.left.onclick=clickleft;this.right=WA.createDomNode('div',null,'slider-button slider-right');if(this.buttonsoutside)
this.node.parentNode.appendChild(this.right);else
this.node.appendChild(this.right);this.right.onclick=clickright;}
KL.galerias.sliderpublicidad=function()
{var self=this;this.node=WA.toDOM('layer-publicidad');this.nodefather=this.node.parentNode;this.nodecousin=this.node.parentNode.previousSibling;if(this.nodecousin.nodeType!=1)
this.nodecousin=this.nodecousin.previousSibling;this.offsetbottom=0;if(this.node.getAttribute("offsetbottom"))
{this.offsetbottom=parseInt(this.node.getAttribute("offsetbottom"),10);}
function scrollpublicidad(event)
{var scrolllocation=WA.browser.getScrollTop();var cousintop=WA.browser.getNodeNodeTop(self.nodecousin,null);var cousinbottom=cousintop+WA.browser.getNodeOuterHeight(self.nodecousin);var layerheight=WA.browser.getNodeOuterHeight(self.node);if(!self.node.classList.contains("vertical-ad"))
{self.nodefather.style.height=(cousinbottom-cousintop-self.offsetbottom)+'px';if(scrolllocation>cousintop)
{self.node.style.top=(scrolllocation-cousintop)+'px';if(scrolllocation>cousinbottom-layerheight-self.offsetbottom)
self.node.style.top=(cousinbottom-cousintop-self.offsetbottom-layerheight)+'px';}
else
self.node.style.top='0';}
else
{self.nodefather.style.height=(cousinbottom-cousintop-self.offsetbottom)+'px';var referenceBottom=null;if(document.querySelectorAll('.columna.variable')&&document.querySelectorAll('.columna.variable')[0])
{var referenceNode=document.querySelectorAll('.columna.variable')[0];var referenceTop=WA.browser.getNodeNodeTop(referenceNode);referenceBottom=referenceTop+WA.browser.getNodeOuterHeight(referenceNode);}
if(scrolllocation>cousinbottom)
{self.node.style.top=(scrolllocation-cousinbottom)+'px';if(referenceBottom&&(scrolllocation>referenceBottom-layerheight-self.offsetbottom))
self.node.style.top=(referenceBottom-cousinbottom-self.offsetbottom-layerheight)+'px';}
else
self.node.style.top='0';}}
this.adjust=adjust;function adjust()
{self.node.className='layer-publicidad-anim';scrollpublicidad();setTimeout(function(){self.node.className='';},200);}
WA.Managers.event.on('scroll',window,scrollpublicidad,true);}
WA.Managers.event.on('load',window,KL.galerias.start,true);KL.touchslider=new function()
{var self=this;this.zones={};this.currentid=null;this.counter=1;this.startzone=startzone;function startzone(node,listener)
{if(!node||!listener)
return;if(!node.id)
node.id='touchslider-'+self.counter;this.zones[node.id]=new KL.touchslider.zone(node,listener);self.counter++;}
function drag(event)
{if(!self.currentid)
return;if(self.zones[self.currentid])
self.zones[self.currentid].drag(event);}
function release(event)
{if(!self.currentid)
return;if(self.zones[self.currentid])
self.zones[self.currentid].release(event);self.currentid=null;}
WA.Managers.event.on('touchmove',document,drag,true);WA.Managers.event.on('touchend',document,release,true);}
KL.touchslider.zone=function(node,listener)
{var self=this;this.node=node;this.id=node.id;this.listener=listener;this.x=this.y=0;function start(event)
{KL.touchslider.currentid=self.id;self.x=WA.browser.getTouchDocumentX(event);self.y=WA.browser.getTouchDocumentY(event);if(!self.listener.call(this,'start',{x:self.x,y:self.y}))
WA.browser.cancelEvent(event);}
this.drag=drag;function drag(event)
{self.dx=self.x-WA.browser.getTouchDocumentX(event);self.dy=self.y-WA.browser.getTouchDocumentY(event);if(!self.listener.call(this,'drag',{x:self.x,y:self.y,dx:self.dx,dy:self.dy}))
WA.browser.cancelEvent(event);}
this.release=release;function release(event)
{if(Math.abs(self.dx)>=Math.abs(self.dy))
{if(self.dx>=0)
self.listener.call(this,'right');else
self.listener.call(this,'left');}
else
{if(self.dy>=0)
self.listener.call(this,'down');else
self.listener.call(this,'up');}
if(!self.listener.call(this,'release',{x:self.x,y:self.y,dx:self.dx,dy:self.dy}))
WA.browser.cancelEvent(event);}
WA.Managers.event.on('touchstart',this.node,start,true);}
function galeriaMove(direction)
{if(WA.toDOM('galeria-horizontal'))
{var ghWidth=WA.toDOM('galeria-horizontal').offsetWidth;var actualposition=WA.toDOM('galeria-content').offsetLeft;var elements=WA.toDOM('galeria-content').firstElementChild.firstElementChild.childElementCount;var elementSize=WA.toDOM('galeria-content').firstElementChild.firstElementChild.firstElementChild.offsetWidth;var size=(elements-1)*(elementSize+40);var moveTarget=null;WA.toDOM('galeria-content').style.width=size+'px';if(direction=='ghleft')
{moveTarget=ghWidth+Math.abs(actualposition);if(moveTarget>=(size-ghWidth))
WA.toDOM('galeria-content').style.left='-'+(size-ghWidth)+'px';else
WA.toDOM('galeria-content').style.left='-'+moveTarget+'px';}
if(direction=='ghright')
{if(actualposition==0)
WA.toDOM('galeria-content').style.left='0px';else
{moveTarget=actualposition+ghWidth;if(moveTarget>=0)
WA.toDOM('galeria-content').style.left='0px';else
WA.toDOM('galeria-content').style.left=moveTarget+'px';}}}}
function display_first()
{WA.toDOM('slider-lista').firstElementChild.className="bloque slider_lista on";WA.toDOM('slider-lista').firstElementChild='active';}
function next(clave)
{var node=WA.toDOM('elemento_'+clave);if(node.nextElementSibling)
{node.className='bloque slider_lista';node.nextElementSibling.className="bloque slider_lista on";}}
function prev(clave)
{var node=WA.toDOM('elemento_'+clave);if(node.previousElementSibling)
{node.className='bloque slider_lista';node.previousElementSibling.className="bloque slider_lista on";}}
function startpanelidvertical(clave,hop)
{if(!WA.toDOM('panelid'+clave))
return;panelids[clave]={};panelids[clave].container=WA.toDOM('panelcontainer'+clave);panelids[clave].panel=WA.toDOM('panelid'+clave);panelids[clave].hop=hop;var max=0;for(var i=0;i<panelids[clave].panel.childNodes.length;i++)
{var x=WA.browser.getNodeNodeTop(panelids[clave].panel.childNodes[i],panelids[clave].panel);if(x!=undefined)
x+=WA.browser.getNodeHeight(panelids[clave].panel.childNodes[i]);if(x!=undefined&&x>max)
max=x;}
if(max>WA.browser.getNodeHeight(panelids[clave].container))
{WA.toDOM('panelcontrol-abajo'+clave).style.display='';WA.toDOM('panelcontrol-arriba'+clave).className='control-arriba off';panelids[clave].max=max-WA.browser.getNodeHeight(panelids[clave].container);}
else
{WA.toDOM('panelcontrol-arriba'+clave).style.display='none';WA.toDOM('panelcontrol-abajo'+clave).style.display='none';}}
function panelmoverarriba(clave)
{var x=parseInt(panelids[clave].panel.style.top,10)+panelids[clave].hop;if(x>=0)
{x=0;WA.toDOM('panelcontrol-arriba'+clave).className='control-arriba off';}
else
{WA.toDOM('panelcontrol-arriba'+clave).className='control-arriba';}
WA.toDOM('panelcontrol-abajo'+clave).className='control-abajo';WA.get(panelids[clave].panel).move(500,null,x,null,null,parseInt(panelids[clave].panel.style.top,10));}
function panelmoverabajo(clave)
{var OFF_CLASS='control-abajo off';var controlAbajoIsOff=WA.toDOM('panelcontrol-abajo'+clave).className===OFF_CLASS;if(controlAbajoIsOff)
return;var BUTTON_HEIGHT=0;var x=parseInt(panelids[clave].panel.style.top,10)-panelids[clave].hop;var panelOffset=(panelids[clave].hop-BUTTON_HEIGHT)||0;var panelHeight=(panelids[clave].panel.clientHeight-panelOffset)||200;if(x<=-panelHeight)
{x=-panelHeight;WA.toDOM('panelcontrol-abajo'+clave).className='control-abajo off';}
else
{WA.toDOM('panelcontrol-abajo'+clave).className='control-abajo';}
WA.toDOM('panelcontrol-arriba'+clave).className='control-arriba';WA.get(panelids[clave].panel).move(500,null,x,null,null,parseInt(panelids[clave].panel.style.top,10));}
var tipoFlagTmp=null;function agregarlista(tipo,clave)
{var sufijo='';if(tipo.target)
{var aux=getCleanDataFromId(tipo.target);if(aux===null)
return;tipo=aux.tipo;clave=aux.clave;sufijo=aux.sufijo;}
var request=WA.Managers.ajax.createRequest('/listeners/docoleccion','POST','orden=lista',getagregarlista,false);request.addParameter('tipo',tipo);request.addParameter('clave',clave);request.send();}
function agregarnuevalista(tipo,clave)
{var request=WA.Managers.ajax.createRequest('/listeners/docoleccion','POST','orden=nuevalista',getagregarlista,false);request.addParameter('tipo',tipo);request.addParameter('clave',clave);request.send();}
function getagregarlista(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus!='OK')
{if(code.code==1)
{ga('send','event','usuario','usu/coleccion','usu/col/loginabrirpopup',0);return switchpulldown(null,'colecciones');}
else
{ga('send','event','usuario','usu/coleccion','usu/col/errorabrirpopup',0);alerta(code.mensaje);}
return;}
ga('send','event','usuario','usu/coleccion','usu/col/abrirpopup',0);if(code.data)
{var node=WA.toDOM('listacolecciones');if(!node)
{var nbgnode=WA.createDomNode('div','bglistacolecciones');nbgnode.onclick=cierramodalcoleccion;document.body.appendChild(nbgnode);node=WA.createDomNode('div','listacolecciones');document.body.appendChild(node);}
WA.toDOM('bglistacolecciones').style.display='block';node.innerHTML=code.data;node.style.display='block';}}
function cierramodalcoleccion(event)
{WA.toDOM('bglistacolecciones').style.display='none';WA.toDOM('listacolecciones').style.display='none';}
function seleccionacoleccion(tipo,clave,clavecoleccion)
{tipoFlagTmp=tipo;var request=WA.Managers.ajax.createRequest('/listeners/docoleccion','POST','orden=insertar',getseleccionacoleccion,false);request.addParameter('coleccion',clavecoleccion);request.addParameter('tipo',tipo);request.addParameter('clave',clave);request.send();}
function getseleccionacoleccion(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/coleccion','usu/col/agregar',0);if(tipoFlagTmp=='t')
notifica('<p>'+WA.i18n.getMessage("txtgetseleccionacoleccion1")+'</p>'+WA.i18n.getMessage("txtgetseleccionacoleccion2")+' "'+code.nombrecoleccion+'"');else
notifica('<p>'+WA.i18n.getMessage("txtgetseleccionacoleccion1")+'</p>'+WA.i18n.getMessage("txtgetseleccionacoleccion3")+' "'+code.nombrecoleccion+'"');cierramodalcoleccion();}
else
{ga('send','event','usuario','usu/coleccion','usu/col/erroragregar',0);alerta(code.mensaje);}
tipoFlagTmp=null;}
function checkarcoleccion()
{setTimeout(verificacoleccion,0);}
function verificacoleccion()
{var valor=WA.toDOM('coleccionnombre').value;if(valor)
WA.toDOM('coleccionbutton').style.readOnly=true;else
WA.toDOM('coleccionbutton').style.readOnly=false;}
function crearcoleccion(tipo,clave)
{tipoFlagTmp=tipo;var valor=WA.toDOM('coleccionnombre').value;if(valor)
{var request=WA.Managers.ajax.createRequest('/listeners/docoleccion','POST','orden=crear',getcrearcoleccion,false);request.addParameter('nombre',WA.UTF8.encode(valor));request.addParameter('tipo',tipo);request.addParameter('clave',clave);request.send();}}
function getcrearcoleccion(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/coleccion','usu/col/crearagregar',0);if(tipoFlagTmp=='t')
notifica('<p>'+WA.i18n.getMessage("txtgetseleccionacoleccion1")+'</p>'+WA.i18n.getMessage("txtgetcrearcoleccion1"));else
notifica('<p>'+WA.i18n.getMessage("txtgetseleccionacoleccion1")+'</p>'+WA.i18n.getMessage("txtgetcrearcoleccion2"));cierramodalcoleccion();if(verlistacolecciones)
verlistacolecciones();}
else
{ga('send','event','usuario','usu/coleccion','usu/col/errorcrearagregar',0);alerta(code.mensaje);}
tipoFlagTmp=null;}
function agregarfav(tipo,clave,receta)
{var sufijo='';if(tipo.target)
{var aux=getCleanDataFromId(tipo.target);if(aux===null)
return;tipo=aux.tipo;clave=aux.clave;sufijo=aux.sufijo;}
tipoFlagTmp=tipo;if(!receta)
{var nodefav=WA.toDOM('tools_fav_'+tipo+'_'+clave+'_'+sufijo);if(nodefav&&!nodefav.abierto)
{abrir(tipo,clave,sufijo);return;}}
var request=WA.Managers.ajax.createRequest('/listeners/docoleccion','POST','orden=favorito',getagregarfav,false);request.addParameter('tipo',tipo);request.addParameter('clave',clave);request.send();}
function getagregarfav(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/favoritos','usu/fav/agregar',0);if(tipoFlagTmp=='t')
notifica('<p>'+WA.i18n.getMessage("txtgetagregarfav1")+'</p>'+WA.i18n.getMessage("txtgetagregarfav2"));else
notifica('<p>'+WA.i18n.getMessage("txtgetagregarfav1")+'</p>'+WA.i18n.getMessage("txtgetagregarfav3"));}
else
{if(code.code==1)
{ga('send','event','usuario','usu/favoritos','usu/fav/loginagregar',0);return switchpulldown(null,'favoritos');}
else
{alerta(code.mensaje);ga('send','event','usuario','usu/favoritos','usu/fav/erroragregar',0);}}
tipoFlagTmp=null;}
function agregarlistasuper(receta)
{seleccionalistasuper(0,receta)}
function seleccionalistasuper(clavelistasuper,receta)
{var request=WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=insertar',getseleccionalistasuper,false);request.addParameter('listasuper',clavelistasuper);request.addParameter('receta',receta);ing=getingredientes();request.addParameter('ingredientes',ing);request.send();}
function getseleccionalistasuper(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/agregarreceta',0);notifica('<p>'+WA.i18n.getMessage("txtgetseleccionalistasuper1")+'</p>'+WA.i18n.getMessage("txtgetseleccionalistasuper2"));cierramodallistasuper();}
else
{if(code.code==1)
{ga('send','event','usuario','usu/listasuper','usu/lis/loginagregarreceta',0);return switchpulldown(null,'listasuper');}
else
{alerta(code.mensaje);ga('send','event','usuario','usu/listasuper','usu/lis/erroragregarreceta',0);}}}
var lista_Activa=null;var tipo='r';var gmodo='receta';var xmodo=null;function ver_por(T,cl)
{if(!cl)
cl=lista_Activa;if(T)
tipo=T;if(tipo=='r')
{getlista(cl,'receta');gmodo='receta';WA.toDOM('ver_por_r').setAttribute('checked','checked');WA.toDOM('ver_por_p').removeAttribute('checked');WA.toDOM('por_p').style.opacity="0";WA.toDOM('por_r').style.opacity="1";WA.toDOM('txt_verpor_r').className="nomb_ingre ver_por txt_activo txt_activo";WA.toDOM('txt_verpor_p').className="nomb_ingre ver_por txt_activo txt_desactivo";}
else
{getlista(cl,'pasillo');gmodo='pasillo';WA.toDOM('ver_por_p').setAttribute('checked','checked');WA.toDOM('ver_por_r').removeAttribute('checked');WA.toDOM('por_p').style.opacity="1";WA.toDOM('por_r').style.opacity="0";WA.toDOM('txt_verpor_p').className="nomb_ingre ver_por txt_activo";WA.toDOM('txt_verpor_r').className="nomb_ingre ver_por txt_activo txt_desactivo";}}
function getlista(cl,modo)
{if(modo==undefined)
{modo=gmodo;cl='';}
WA.Managers.ajax.createRequest('/listeners/getlistasuper','POST','modo='+modo+'&clave='+cl,muestralista,true);}
function muestralista(request)
{var receta=WA.JSON.decode(request.responseText);var hr='<a  href="/imprimir-listasuper/'+receta['clavelista']+'-'+gmodo+'" target="_blank" onclick="return verificaimprimiringredientes();">';hr+='<div class="implista">';hr+=WA.i18n.getMessage("txtmuestralista");hr+='</div>';hr+='</a>';WA.toDOM('clave_lista').innerHTML=hr;var imp_m='<a  href="/imprimir-listasuper/'+receta['clavelista']+'-'+gmodo+'" target="_blank" onclick="return verificaimprimiringredientes();">'
+'<div class="dv_cont_herramientafooter">'
+'<div class="div_icon_herramientafooter imprimir"></div> '
+'<div class="div_txt_herramientafooter">'
+WA.i18n.getMessage("txtmuestralista")
+'</div>'
+'</div>'
+'</a>';WA.toDOM("imprimir_lista_m").innerHTML=imp_m;WA.toDOM('enviarlista').innerHTML='<div class="envlista" onclick="EnviarMailLista('+receta['clavelista']+',\''+gmodo+'\')">Enviar</div>';var env_m='<div class="dv_cont_herramientafooter" onclick="EnviarMailLista('+receta['clavelista']+',\''+gmodo+'\')" id="enviar_lista_m">'
+'<div class="div_icon_herramientafooter mail"></div>'
+'<div class="div_txt_herramientafooter">'
+WA.i18n.getMessage("txtmuestralista1")
+'</div>'
+'</div>';WA.toDOM('enviar_lista_m').innerHTML=env_m;WA.toDOM('listaderecetas').innerHTML=receta['template'];WA.toDOM('lista_imagenes').innerHTML=receta['lista_imagenes'];lista_Activa=receta['clavelista'];verificaCheckActivos();}
function verificaCheckActivos()
{return true;var lista=WA.toDOM("listaderecetas");var minimouno=false;for(var i=0;i<lista.childNodes.length;i++)
{if(lista.childNodes[i].id)
{var todos=true;for(var j=0;j<=100;j++)
{var xlista=WA.toDOM(lista.childNodes[i].id+'_'+j);if(xlista)
{minimouno|=xlista.checked;todos&=xlista.checked;}}
if(WA.toDOM(lista.childNodes[i].id+'_todos'))
WA.toDOM(lista.childNodes[i].id+'_todos').checked=todos;}}
return minimouno;}
var listasuperparaborrar=null;function Eliminalistas(clave)
{listasuperparaborrar=clave;confirma(WA.i18n.getMessage("txtEliminalistas"),WA.i18n.getMessage("txtherramientas1"),WA.i18n.getMessage("txtherramientas2"),doeliminalistas);}
function doeliminalistas(id)
{if(id==1)
{var request=WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=elimina_todo',Eliminalistasrespuesta,false);request.addParameter('clave',listasuperparaborrar);request.send();}
listasuperparaborrar=null;}
function Eliminalistasrespuesta(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/borrarlista',0);WA.toDOM("listado_"+code['clave']).style.display='none';if(lista_Activa==code['clave'])
getlista();notifica(WA.i18n.getMessage("txtEliminalistasrespuesta"));}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorborrarlista',0);alerta(code.mensaje);}}
function Validacamposmail()
{if(WA.toDOM("mptitulo").value.trim()==''||WA.toDOM("mpparacorreo").value.trim()==''||WA.toDOM("mpmensaje").value.trim()=='')
{WA.toDOM('enviarmail').disabled='true';WA.toDOM('enviarmail').style.background='#bbb';}
else
{WA.toDOM('enviarmail').disabled=false;WA.toDOM('enviarmail').style.background='#8cc63e';}}
function EnviarMailLista(clave,modo)
{if(verificaCheckActivos()==true)
{Validacamposmail();WA.toDOM("fondonegro").style.display="block";WA.toDOM("enviacorreo").style.display="block";WA.toDOM("fondonegro").style.opacity="1";WA.toDOM("enviacorreo").style.opacity="1";WA.toDOM("claveoculta").value=clave;WA.toDOM("modooculto").value=modo;}
else
{alerta(WA.i18n.getMessage("txtEnviarMailLista"));}}
function quitarfondonegro()
{WA.toDOM("fondonegro").style.opacity="0";WA.toDOM("enviacorreo").style.opacity="0";setTimeout(function(){WA.toDOM("fondonegro").style.display="none";WA.toDOM("enviacorreo").style.display="none";},500);}
function Enviarlistas()
{WA.toDOM("imagen_mail_boton").style.display='none';WA.toDOM("imagen_mail_carga").style.display='block';var cl=WA.toDOM("claveoculta").value;var modo=WA.toDOM("modooculto").value;var titulo=WA.toDOM("mptitulo").value;var paracorreo=WA.toDOM("mpparacorreo").value;var mensaje=WA.toDOM("mpmensaje").value;var request=WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=envia_correo&clave='+cl+'&modo='+modo,correoenviado,false);request.addParameter('titulo',WA.UTF8.encode(titulo));request.addParameter('paracorreo',WA.UTF8.encode(paracorreo));request.addParameter('mensaje',WA.UTF8.encode(mensaje));request.send();}
function correoenviado(request)
{quitarfondonegro();var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/enviarcorreo',0);notifica(WA.i18n.getMessage("txtcorreoenviado"));WA.toDOM("imagen_mail_boton").style.display='block';WA.toDOM("imagen_mail_carga").style.display='none';}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorenviarcorreo',0);alerta(code.mensaje);}}
function verificaimprimiringredientes()
{return true;}
var nodemodificaroriginal=null;var nodemodificarlista=null;var clavemodificarlista=null;var modo=null;var claveglo=null;function modificarlista(clave,mod)
{modo=mod;claveglo=clave;if(nodemodificarlista)
return;if(modo==1)
{nodemodificaroriginal=WA.toDOM('nombrelista_'+clave).innerHTML;}
else
{WA.toDOM('lista_'+clave).removeAttribute('onclick');nodemodificaroriginal=WA.toDOM('lista_'+clave).innerHTML;}
nodemodificarlista=WA.createDomNode('input','campomodificarlista',null);nodemodificarlista.type='text';nodemodificarlista.value=nodemodificaroriginal;nodemodificarlista.onblur=blurmodificarlista;nodemodificarlista.onkeydown=keymodificarlista;clavemodificarlista=clave;if(modo==1)
{WA.toDOM('nombrelista_'+clave).innerHTML='';WA.toDOM('nombrelista_'+clave).appendChild(nodemodificarlista);}
else
{WA.toDOM('lista_'+clave).innerHTML='';WA.toDOM('lista_'+clave).appendChild(nodemodificarlista);}
nodemodificarlista.focus();}
function blurmodificarlista(event)
{var valor=nodemodificarlista.value;if(modo==1)
WA.toDOM('nombrelista_'+clavemodificarlista).innerHTML=valor;else
{WA.toDOM('lista_'+clavemodificarlista).innerHTML=valor;if(WA.toDOM('nombrelista_'+clavemodificarlista))
WA.toDOM('nombrelista_'+clavemodificarlista).innerHTML=valor;}
var request=WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=modificar',getmodificarlista,false);request.addParameter('clave',clavemodificarlista);request.addParameter('nombre',WA.UTF8.encode(valor));request.send();nodemodificarlista=null;clavemodificarlista=null;}
function keymodificarlista(event)
{var keyCode=('which'in event)?event.which:event.keyCode;if(keyCode==13)
blurmodificarlista(event);if(keyCode==27)
{nodemodificarlista.value=nodemodificaroriginal;blurmodificarlista(event);}}
function getmodificarlista(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/cambianombrelista',0);notifica(WA.i18n.getMessage("txtgetmodificarlista"));if(WA.toDOM('lista_'+code.clave))
WA.toDOM('lista_'+code.clave).innerHTML=code.nombre;if(nodemodificaroriginal==WA.toDOM('titulo_lista_img').innerHTML)
{if(WA.toDOM('titulo_lista_img'))
WA.toDOM('titulo_lista_img').innerHTML=code.nombre;}
WA.toDOM('lista_'+claveglo).setAttribute('onclick','ver_por(null,'+claveglo+')');WA.toDOM('lista_'+claveglo).innerHTML=code.nombre;}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorcambianombrelista',0);alerta(code.mensaje);}}
recetadelistaparaeliminar=null;detalledelistaparaeliminar=null;function eliminarreceta(receta,clavedetalle)
{recetadelistaparaeliminar=receta;detalledelistaparaeliminar=clavedetalle;confirma(WA.i18n.getMessage("txteliminarreceta"),WA.i18n.getMessage("txtherramientas1"),WA.i18n.getMessage("txtherramientas2"),doeliminareceta);}
function doeliminareceta(id)
{if(id==1)
{WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=eliminar_receta&clavedetalle='+detalledelistaparaeliminar,recetaeliminada,true);var element=WA.toDOM("receta_"+detalledelistaparaeliminar);if(element)
element.parentNode.removeChild(element);var imagen=WA.toDOM("imagen_"+recetadelistaparaeliminar);if(imagen)
imagen.parentNode.removeChild(imagen);var nodo=WA.toDOM('listaderecetas')
if(nodo&&nodo.childElementCount==0)
{WA.toDOM("listaderecetas").innerHTML='<div class="no_existe">'+WA.i18n.getMessage("txtdoeliminareceta1")+'</div>';WA.toDOM("lista_imagenes").innerHTML='<div style="font-family: Source-Semibold; font-size: 14px;">'+WA.i18n.getMessage("txtdoeliminareceta2")+'</div>';}
if(WA.toDOM('receta_-1')&&nodo.childElementCount==1)
WA.toDOM("lista_imagenes").innerHTML='<div style="font-family: Source-Semibold; font-size: 14px;"> '+WA.i18n.getMessage("txtdoeliminareceta2")+'</div>';}
recetadelistaparaeliminar=null;detalledelistaparaeliminar=null;}
function recetaeliminada(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/quitareceta',0);notifica("La receta fue eliminada");}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorquitareceta',0);alerta(code.mensaje);}}
function activaboton(texto,event)
{if(texto.length>=3)
{WA.toDOM('agregaring').disabled=false;WA.toDOM('agregaring').style.background='#8cc63e';if(event)
{var code=WA.browser.getKey(event);if(code==13)
agregarextra();}}
else
{WA.toDOM('agregaring').disabled=true;WA.toDOM('agregaring').style.background='#bbb';}}
function agregarextra()
{var nombreingrediente=WA.toDOM('newing').value;if(nombreingrediente)
WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=agrega_extra&nombreingrediente='+nombreingrediente+'&clavelista='+lista_Activa,extraagregado,true);}
function extraagregado(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/agregaringrediente',0);getlista(code.lista,gmodo);notifica("Se agregó el ingrediente exitosamente a la lista");}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/erroragregaringrediente',0);alerta(code.mensaje);}
WA.toDOM('newing').value='';WA.toDOM('agregaring').disabled=true;WA.toDOM('agregaring').style.background='#bbb';}
var ingredienteparaeliminar=null;function eliminaingrediente(clavedetalle)
{ingredienteparaeliminar=clavedetalle;confirma(WA.i18n.getMessage("txteliminaingrediente"),WA.i18n.getMessage("txtherramientas1"),WA.i18n.getMessage("txtherramientas2"),doeliminaingrediente);}
function doeliminaingrediente(id)
{if(id==1)
{WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=elimina_ingrediente&claveingrediente='+ingredienteparaeliminar,ingredienteeliminado,true);}
ingredienteparaeliminar=null;}
function ingredienteeliminado(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/quitaringrediente',0);notifica("El ingrediente fue eliminado con éxito");getlista(lista_Activa,gmodo);}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorquitaringrediente',0);alerta(code.mensaje);}}
var extraparaeliminar=null;function eliminaextra(clavedetalle)
{extraparaeliminar=clavedetalle;confirma(WA.i18n.getMessage("txteliminaextra"),WA.i18n.getMessage("txtherramientas1"),WA.i18n.getMessage("txtherramientas2"),doeliminaextra);}
function doeliminaextra(id)
{if(id==1)
{WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=elimina_extra&claveextra='+extraparaeliminar,extraeliminado,true);}
extraparaeliminar=null;}
function extraeliminado(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/quitaringrediente',0);notifica(WA.i18n.getMessage("txtextraeliminado"));getlista(lista_Activa,gmodo);}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorquitaringrediente',0);alerta(code.mensaje);}}
function activaingrediente(ingrediente,lista,pasillo,tipo,status,todos,clavelista)
{var activo=0;if(status==true)
activo=1;if(todos=='SI')
{WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=activartodos&lista='+lista+'&activo='+activo+'&tipo='+tipo+'&pasillo='+pasillo+'&clavelista='+clavelista,ingredienteactivado,true);}
else
{if(tipo=='extra')
WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=activarExtra&ingrediente='+ingrediente+'&activo='+activo,ingredienteactivado,true);if(tipo=='normal')
WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=activar&ingrediente='+ingrediente+'&lista='+lista+'&activo='+activo,ingredienteactivado,true);}}
function ingredienteactivado(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{verificaCheckActivos();}
else
alerta(code.mensaje);}
function abrirtutoriallistasuper()
{WA.toDOM('bgtutoriallistasuper').style.display='block';WA.toDOM('tutoriallistasuper').style.display='block';}
function cerrartutoriallistasuper()
{WA.toDOM('bgtutoriallistasuper').style.display='none';WA.toDOM('tutoriallistasuper').style.display='none';}
function switcheliminados(clave)
{WA.toDOM('ingredienteseliminados').style.display='block';}
function recuperaingrediente(clavedetalle)
{WA.Managers.ajax.createRequest('/listeners/dolistasuper','POST','orden=recupera_ingrediente&claveingrediente='+clavedetalle,ingredienterecuperado,true);}
function ingredienterecuperado(request)
{var code=WA.JSON.decode(request.responseText);if(code.estatus=='OK')
{ga('send','event','usuario','usu/listasuper','usu/lis/recuperaringrediente',0);notifica(WA.i18n.getMessage("txtingredienterecuperado"));getlista(lista_Activa,gmodo);}
else
{ga('send','event','usuario','usu/listasuper','usu/lis/errorrecuperaringrediente',0);alerta(code.mensaje);}}
KL.Modules.productodeventa=new function()
{var self=this;var popupcargada=false;var emailformato='^[\\w\\d\\._-]+@([\\w\\d_-]*[\\w\\d]\\.)+([\\w]{2,})$';var formato='^[\\wÁÉÍÓÚÝáéíóúýäëïöüÿÄËÏÖÜàèìòùÀÈÌÒÙñÑ\\d-\\. ]*$';var formatonumeros='^[0-9]{5}$';var globalstatus=false;var estatusformdireccion=false;var estatusformpago=false;var estatusformbasico=false;var botoncompartir=false;function getMP()
{if(KL.devel)
Mercadopago.setPublishableKey("TEST-87edc4ef-3143-418d-bc90-521e7f173785");else
Mercadopago.setPublishableKey("APP_USR-bee9b294-743b-4be6-a436-723e6d808504");}
function getcompra()
{popupcargada=true;WA.Managers.event.on('keyup',document.querySelector('input[data-checkout="cardNumber"]'),guessingPaymentMethod);WA.Managers.event.on('change',document.querySelector('input[data-checkout="cardNumber"]'),guessingPaymentMethod);}
function getcosto()
{}
function show()
{KL.Modules.modal.show('compraproducto');ga('send','event','compra','cobro','pc/abrir',0);}
this.cerrar=cerrar;function cerrar()
{KL.Modules.modal.hide();}
function setPaymentMethodInfo(status,response)
{try
{if(status==200)
{var form=document.querySelector('#payproducto');if(document.querySelector("input[name=paymentMethodId]")==null)
{var paymentMethod=document.createElement('input');paymentMethod.setAttribute('name',"paymentMethodId");paymentMethod.setAttribute('type',"hidden");paymentMethod.setAttribute('value',response[0].id);form.appendChild(paymentMethod);}
else
{document.querySelector("input[name=paymentMethodId]").value=response[0].id;}}}
catch(e)
{if(KL.devel)
console.log('setPaymentMethodInfo  '+e);ga('send','event','compra','error/mp_setpaymentinfo','pc/99',null);KL.manageError(e);}}
function getBin()
{var ccNumber=document.querySelector('input[data-checkout="cardNumber"]');return ccNumber.value.replace(/[ .-]/g,'').slice(0,6);}
function guessingPaymentMethod(event)
{try
{var bin=getBin();if(event.type=="keyup")
{if(bin.length>=6)
{Mercadopago.getPaymentMethod({"bin":bin},setPaymentMethodInfo);}}
else
{setTimeout(function()
{if(bin.length>=6)
{Mercadopago.getPaymentMethod({"bin":bin},setPaymentMethodInfo);}},100);}}
catch(e)
{if(KL.devel)
console.log('guessingPaymentMethod  '+e);ga('send','event','compra','error/mp_guesspaymentinfo','pc/99',null);KL.manageError(e);}}
this.activardelegaciones=activardelegaciones;function activardelegaciones()
{var option=WA.toDOM('Estado').value;if(option=='MX09')
{WA.toDOM('delegacion_envio').style.display='block';WA.toDOM('delegacion_input_envio').style.display='none';WA.toDOM('ciudad_envio').disabled=true;WA.toDOM('ciudad_envio').value='n/a';}
else
{WA.toDOM('delegacion_envio').style.display='none';WA.toDOM('delegacion_input_envio').style.display='block';WA.toDOM('ciudad_envio').disabled=false;WA.toDOM('ciudad_envio').value=' ';}
condireccioncheck();}
var enviado=false;this.pagar=pagar;function pagar()
{try
{if(!enviado)
{Mercadopago.clearSession();var forma=document.querySelector('#payproducto');Mercadopago.createToken(forma,sdkResponseHandler);return false;}}
catch(e)
{if(KL.devel)
console.log('pagar  '+e);ga('send','event','compra','error/pagar','pc/99',null);KL.manageError(e);}}
this.registrarGratuito=registrarGratuito;function registrarGratuito(clave,correo=null)
{try
{var direccion='';var tipocompra='producto';var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/payment/gratuito/'+tipocompra,'POST',null,getventagratuito,false);request.addParameter('orden','pagar');request.addParameter('producto',clave);request.addParameter('tipo',1);request.addParameter('correo',correo);request.send();enviado=true;if(WA.toDOM('boton-descargar'))
WA.toDOM('boton-descargar').value=WA.i18n.getMessage("PROCESANDO");ga('send','event','compra','paymentintent','pc/ok',0);}
catch(e)
{if(KL.devel)
console.log('registrarGratuito  '+e);ga('send','event','compra','error/registrarGratuito','pc/99',null);KL.manageError(e);}}
function sdkResponseHandler(status,response)
{try
{if(status!=200&&status!=201)
{identificaMensajeError(status,response);}
else
{limpiacampos();var direccion='';var tipocompra='producto';var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/payment/mercadopago/'+tipocompra,'POST',null,getventa,false);request.addParameter('orden','pagar');request.addParameter('token',response.id);request.addParameter('tipo',document.querySelector('input[name="paymentMethodId"]').value);if(WA.toDOM('clave_producto').innerHTML!='')
request.addParameter('producto',WA.toDOM('clave_producto').innerHTML);if(WA.toDOM('cantidad_producto').innerHTML!='')
request.addParameter('cantidad',WA.toDOM('cantidad_producto').innerHTML);if(WA.toDOM('total_producto').innerHTML!='')
{var m=WA.toDOM('total_producto').innerHTML;var monto=m.slice(1);request.addParameter('monto',monto);}
if(WA.toDOM('nombre_envio').value!='')
request.addParameter('nombre',WA.toDOM('nombre_envio').value);if(WA.toDOM('usuario_envio').value!='')
request.addParameter('correo',WA.toDOM('usuario_envio').value);if(condireccion)
{request.addParameter('condireccion',1);if(WA.toDOM('calle_envio').value!='')
request.addParameter('calle',WA.toDOM('calle_envio').value);if(WA.toDOM('numext_envio').value!='')
request.addParameter('numext',WA.toDOM('numext_envio').value);if(WA.toDOM('numint_envio').value!='')
request.addParameter('numint',WA.toDOM('numint_envio').value);if(WA.toDOM('Estado').value!='')
request.addParameter('estado',WA.toDOM('Estado').value);if(WA.toDOM('ciudad_envio').value!='')
request.addParameter('ciudad',WA.toDOM('ciudad_envio').value);if(WA.toDOM('delegacion_envio').value!==''&&WA.toDOM('delegacion_envio').value!=='Selecciona una opción')
request.addParameter('delegacion',WA.toDOM('delegacion_envio').value);else
{if(WA.toDOM('delegacion_input_envio').value!=='')
request.addParameter('delegacion',WA.toDOM('delegacion_input_envio').value);}
if(WA.toDOM('colonia_envio').value!='')
request.addParameter('colonia',WA.toDOM('colonia_envio').value);if(WA.toDOM('codigopostal_envio').value!='')
request.addParameter('codigopostal',WA.toDOM('codigopostal_envio').value);if(WA.toDOM('telefono_envio').value!='')
request.addParameter('telefono',WA.toDOM('telefono_envio').value);}
request.send();enviado=true;WA.toDOM('botoncompraproducto').value=WA.i18n.getMessage("PROCESANDO");ga('send','event','compra','paymentintent','pc/ok',0);}}
catch(e)
{if(KL.devel)
console.log('sdkResponseHandler  '+e);ga('send','event','compra','error/paymentintent','pc/99',null);KL.manageError(e);}}
function getventa(request)
{try
{venta=WA.JSON.decode(request.responseText);var str=venta.detalle;var detalle=str.replace("payment_method_id",venta.metodo_pago);var str1=detalle.replace("statement_descriptor",venta.statement_descriptor);var mensaje=str1.replace("amount",venta.amount);var numerodepedido='';switch(venta.mensaje)
{case'approved':if(WA.toDOM('formulario-descripcion'))
WA.toDOM('formulario-descripcion').style.display='none';if(WA.toDOM('formulario-envio'))
WA.toDOM('formulario-envio').style.display='none';if(WA.toDOM('formulario-pago'))
WA.toDOM('formulario-pago').style.display='none';if(WA.toDOM('div_licuadora_flotante'))
WA.toDOM('div_licuadora_flotante').style.display='none';if(WA.toDOM('gracias'))
{actualizanombre();WA.toDOM('gracias').style.display='block';mostrarHeader();}
if(venta.fecha_envio)
{if(WA.toDOM('fecha_envio'))
WA.toDOM('fecha_envio').innerHTML=venta.fecha_envio;if(WA.toDOM('num_envio'))
{numerodepedido=creaNumeroDePedido(venta.envio);WA.toDOM('num_envio').innerHTML='# '+numerodepedido;}}
document.body.scrollTop='0px';ga('send','event','compra','payment','pc/ok',venta.amount);ga('ecommerce:addTransaction',{'id':venta.order,'affiliation':'InSite','revenue':venta.amount,'shipping':'0','tax':'0','currency':'MXN'});ga('ecommerce:addItem',{'id':venta.order,'name':venta.productname,'sku':venta.product,'category':'Licuadoras','price':'649','quantity':venta.quantity,'currency':'MXN'});ga('ecommerce:send');fbq('track','Purchase',{currency:"MXN",value:venta.amount});break;case'in_process':alerta(mensaje,'Enterado');enviado=false;limpiacampos();if(WA.toDOM('botoncompraproducto'))
WA.toDOM('botoncompraproducto').value=WA.i18n.getMessage("txtpventa2");if(WA.toDOM('botoncompraproducto'))
WA.toDOM('botoncompraproducto').style.backgroundColor='#8cc63e';ga('send','event','compra','payment','pc/ok',venta.amount);ga('ecommerce:addTransaction',{'id':venta.order,'affiliation':'InSite','revenue':venta.amount,'shipping':'0','tax':'0','currency':'MXN'});ga('ecommerce:addItem',{'id':venta.order,'name':venta.productname,'sku':venta.product,'category':'Licuadoras','price':'649','quantity':venta.quantity,'currency':'MXN'});ga('ecommerce:send');fbq('track','Purchase',{currency:"MXN",value:venta.amount});break;case'rejected':alerta(mensaje,'OK');enviado=false;limpiacampos();if(WA.toDOM('botoncompraproducto'))
{WA.toDOM('botoncompraproducto').value=WA.i18n.getMessage("txtpventa2");WA.toDOM('botoncompraproducto').style.backgroundColor='#8cc63e';}
ga('send','event','compra','paymentrejected','pc/ok',0);break;default:enviado=false;alerta(venta.mensaje,'Ok');ga('send','event','compra','paymentrejected','pc/ok',0);break;}}
catch(e)
{if(KL.devel)
console.log('getventa  '+e);ga('send','event','compra','error/payment','pc/99',null);KL.manageError(e);}}
function getventagratuito(request)
{try
{if(document.getElementById("tituloRecetarioGratuito"))
document.getElementById("tituloRecetarioGratuito").value="nuevo valor del titulo";venta=WA.JSON.decode(request.responseText);var str=venta.detalle;if(WA.toDOM('boton-descargar')){WA.toDOM('boton-descargar').value='Descarga AHORA';}
var numerodepedido='';if(WA.toDOM('formulario-descripcion'))
WA.toDOM('formulario-descripcion').style.display='none';if(WA.toDOM('formulario-envio'))
WA.toDOM('formulario-envio').style.display='none';if(WA.toDOM('formulario-pago'))
WA.toDOM('formulario-pago').style.display='none';if(WA.toDOM('div_licuadora_flotante'))
WA.toDOM('div_licuadora_flotante').style.display='none';if(WA.toDOM('gracias'))
{actualizanombre();WA.toDOM('gracias').style.display='block';mostrarHeader();}
document.body.scrollTop='0px';ga('send','event','compra','payment','pc/ok',venta.amount);ga('ecommerce:addTransaction',{'id':venta.order,'affiliation':'InSite','revenue':venta.amount,'shipping':'0','tax':'0','currency':'MXN'});ga('ecommerce:addItem',{'id':venta.order,'name':venta.productname,'sku':venta.product,'category':'Licuadoras','price':'649','quantity':venta.quantity,'currency':'MXN'});ga('ecommerce:send');fbq('track','Purchase',{currency:"MXN",value:venta.amount});window.open(venta.url,'_blank');window.location.reload();}
catch(e)
{if(KL.devel)
console.log('getventa  '+e);ga('send','event','compra','error/payment','pc/99',null);KL.manageError(e);}}
function cierraventana()
{KL.popup.hide();}
function limpiacampos()
{try
{['cardNumber_error','cardExpirationMonth_error','cardExpirationYear_error','cardholderName_error','securityCode_error','mensaje_usuario'].forEach(function(i){WA.toDOM(i).innerHTML=""});}
catch(e)
{if(KL.devel)
console.log('limpiacampos  '+e);ga('send','event','compra','error/limpiacampos','pc/99',null);KL.manageError(e);}}
function identificaMensajeError(status,response)
{try
{limpiacampos();if(!response||!response.cause)
{if(WA.toDOM('mensaje_usuario'))
WA.toDOM('mensaje_usuario').innerHTML=WA.i18n.getMessage("txtpventa3");return;}
var mensaje="",elementoHTML="";for(var i=0,l=response.cause.length;i<l;i++)
{switch(response.cause[i].code)
{case"205":mensaje=WA.i18n.getMessage("txtpventa4");elementoHTML="cardNumber_error";break;case"208":mensaje=WA.i18n.getMessage("txtpventa5");elementoHTML="cardExpirationMonth_error";break;case"209":mensaje=WA.i18n.getMessage("txtpventa6");elementoHTML="cardExpirationYear_error";break;case"221":mensaje=WA.i18n.getMessage("txtpventa7");elementoHTML="cardholderName_error";break;case"224":mensaje=WA.i18n.getMessage("txtpventa8");elementoHTML="securityCode_error";break;case"E301":mensaje=WA.i18n.getMessage("txtpventa9");elementoHTML="cardNumber_error";break;case"E302":mensaje=WA.i18n.getMessage("txtpventa10");elementoHTML="securityCode_error";break;case"316":mensaje=WA.i18n.getMessage("txtpventa11");elementoHTML="cardholderName_error";break;case"325":mensaje=WA.i18n.getMessage("txtpventa12");elementoHTML="cardExpirationMonth_error";break;case"326":mensaje=WA.i18n.getMessage("txtpventa13");elementoHTML="cardExpirationYear_error";break;default:mensaje=WA.i18n.getMessage("txtpventa14");var elementoHTML="mensaje_usuario";break;}
WA.toDOM(elementoHTML).innerHTML+=mensaje;WA.toDOM(elementoHTML).style.display='block';}}
catch(e)
{if(KL.devel)
console.log('identificaMensajeError  '+e);ga('send','event','compra','error/identificaMensajeError','pc/99',null);KL.manageError(e);}}
this.pago_cancelar=pago_cancelar;function pago_cancelar()
{KL.Modules.modal.show('popup-cancelarpago',undefined,undefined,"top");}
this.pago_cambiar=pago_cambiar;function pago_cambiar()
{WA.toDOM('compraproducto-pago').style.display='block';validar_campos_pago();}
this.abrepago=abrepago;function abrepago()
{KL.Modules.modal.show('popup-tarjeta',undefined,undefined,undefined);enviado=false;WA.toDOM('botoncompraproducto').value=WA.i18n.getMessage("txtpventa2");limpiacampos();}
this.agregarCantidadCompra=agregarCantidadCompra;function agregarCantidadCompra(menos,mas)
{var actual=WA.toDOM('cantidad_producto').innerHTML;actual.trim();actual++;var precio=WA.toDOM('precio_producto').innerHTML;var total=precio*actual;WA.toDOM('cantidad_producto').innerHTML=actual;WA.toDOM('total_producto').innerHTML='$'+total;WA.toDOM('cantidad_producto_flotante').innerHTML=actual;WA.toDOM('precio_producto_flotante').innerHTML='$'+total;}
this.quitarCantidadCompra=quitarCantidadCompra;function quitarCantidadCompra()
{var actual=WA.toDOM('cantidad_producto').innerHTML;actual.trim();actual--;if(actual<=0)
actual=1;var precio=WA.toDOM('precio_producto').innerHTML;var total=precio*actual;WA.toDOM('cantidad_producto').innerHTML=actual;WA.toDOM('total_producto').innerHTML='$'+total;WA.toDOM('cantidad_producto_flotante').innerHTML=actual;WA.toDOM('precio_producto_flotante').innerHTML='$'+total;}
var datosbasicosready=false;var nombre_envio=null;var usuario_envio=null;function startformdatosbasicos()
{if(datosbasicosready)
return;try
{nombre_envio=new validator.textfield('nombre_envio',{minlength:2,maxlength:50,format:formato},'nombre_enviomsg',datosbasicoscheck);usuario_envio=new validator.textfield('usuario_envio',{maxlength:250,format:emailformato},'usuario_enviomsg',datosbasicoscheck);datosbasicosready=true;datosbasicoscheck();}
catch(e)
{ga('send','event','compra','error/startformdatosbasicos','pc/99',null);if(KL.devel)
console.log('startformdatosbasicos  '+e);KL.manageError(e);}}
this.datosbasicoscheck=datosbasicoscheck;function datosbasicoscheck()
{if(!datosbasicosready)
return;try
{if(!nombre_envio.status&&nombre_envio.blurred)
{var nombre=WA.toDOM('nombre_envio').value;if(!nombre||nombre=='')
errorform('nombre_envio',WA.i18n.getMessage("txtpventa15"));else
errorform('nombre_envio',WA.i18n.getMessage("txtpventa16"));}
else
limpiacampo('nombre_envio');if(!usuario_envio.status&&usuario_envio.blurred)
{var usuario=WA.toDOM('usuario_envio').value;if(!usuario||usuario=='')
errorform('usuario_envio',WA.i18n.getMessage("txtpventa17"));else
errorform('usuario_envio',WA.i18n.getMessage("txtpventa18"));}
else
limpiacampo('usuario_envio');estatusformbasico=nombre_envio.status&&usuario_envio.status;console.log("estatusformbasico "+estatusformbasico);activarBotonGlobal();return true;}
catch(e)
{ga('send','event','compra','error/datosbasicoscheck','pc/99',null);if(KL.devel)
console.log('datosbasicoscheck  '+e);KL.manageError(e);}}
this.validar_campos_pago=validar_campos_pago;function validar_campos_pago()
{try
{if(WA.toDOM("cardNumber").value.trim()!=''&&WA.toDOM("cardExpirationMonth").value.trim()!=''&&WA.toDOM("cardExpirationYear").value.trim()!=''&&WA.toDOM("securityCode").value.trim()!=''&&WA.toDOM("cardholderName").value.trim()!='')
{estatusformpago=true;console.log("estatusformpago"+estatusformpago);activarBotonGlobal();}}
catch(e)
{ga('send','event','compra','error/validar_campos_pago','pc/99',null);KL.manageError(e);if(KL.devel)
console.log('validar_campos_pago  '+e);}}
var condireccionready=false;var calle_envio=null;var numext_envio=null;var numint_envio=null;var ciudad_envio=null;var colonia_envio=null;var codigopostal_envio=null;var telefono_envio=null;function startformcondireccion()
{if(condireccionready)
return;try
{calle_envio=new validator.textfield('calle_envio',{minlength:2,maxlength:50,format:formato},'calle_enviomsg',condireccioncheck);numext_envio=new validator.textfield('numext_envio',{minlength:1,notempty:true},'numext_enviomsg',condireccioncheck);numint_envio=new validator.textfield('numint_envio',{notempty:false},'numint_enviomsg',condireccioncheck);ciudad_envio=new validator.textfield('ciudad_envio',{minlength:2,maxlength:80,notempty:true},'ciudad_enviomsg',condireccioncheck);colonia_envio=new validator.textfield('colonia_envio',{minlength:2,maxlength:80,notempty:true},'colonia_enviomsg',condireccioncheck);codigopostal_envio=new validator.textfield('codigopostal_envio',{minlength:5,notempty:true,maxlength:5,format:formatonumeros},'codigopostal_enviomsg',condireccioncheck);telefono_envio=new validator.textfield('telefono_envio',{minlength:6,maxlength:20,notempty:true},'telefono_enviomsg',condireccioncheck);condireccionready=true;condireccioncheck();}
catch(e)
{ga('send','event','compra','error/startformcondireccion','pc/99',null);if(KL.devel)
console.log('startformcondireccion  '+e);KL.manageError(e);}}
this.condireccioncheck=condireccioncheck;function condireccioncheck()
{if(!condireccionready)
return;try
{if(!calle_envio.status&&calle_envio.blurred)
{var calle=WA.toDOM('calle_envio').value;if(!calle||calle=='')
errorform('calle_envio',WA.i18n.getMessage("txtpventa19"));else
errorform('calle_envio',WA.i18n.getMessage("txtpventa20"));}
else
limpiacampo('calle_envio');if(!numext_envio.status&&numext_envio.blurred)
{var numext=WA.toDOM('numext_envio').value;if(!numext||numext=='')
errorform('numext_envio',WA.i18n.getMessage("txtpventa21"));else
errorform('numext_envio',WA.i18n.getMessage("txtpventa22"));}
else
limpiacampo('numext_envio');if(!ciudad_envio.status&&ciudad_envio.blurred)
{var ciudad=WA.toDOM('ciudad_envio').value;if(!ciudad||ciudad=='')
errorform('ciudad_envio',WA.i18n.getMessage("txtpventa23"));else
errorform('ciudad_envio',WA.i18n.getMessage("txtpventa20"));}
else
limpiacampo('ciudad_envio');if(!colonia_envio.status&&colonia_envio.blurred)
{var colonia=WA.toDOM('colonia_envio').value;if(!colonia||colonia=='')
errorform('colonia_envio',WA.i18n.getMessage("txtpventa24"));else
errorform('colonia_envio',WA.i18n.getMessage("txtpventa20"));}
else
limpiacampo('colonia_envio');if(!codigopostal_envio.status&&codigopostal_envio.blurred)
{var codigopostal=WA.toDOM('codigopostal_envio').value;if(!codigopostal||codigopostal=='')
errorform('codigopostal_envio',WA.i18n.getMessage("txtpventa25"));else
errorform('codigopostal_envio','Debe de tener 5 digitos');}
else
limpiacampo('codigopostal_envio');if(!telefono_envio.status&&telefono_envio.blurred)
{var telefono=WA.toDOM('telefono_envio').value;if(!telefono||telefono=='')
errorform('telefono_envio',WA.i18n.getMessage("txtpventa26"));else
errorform('telefono_envio',WA.i18n.getMessage("txtpventa27"));}
else
limpiacampo('telefono_envio');var statusestado=true;var estado=WA.toDOM('Estado').value;if(!estado)
{errorform('Estado',WA.i18n.getMessage("txtpventa28"));statusestado=false;}
else
limpiacampo('Estado');if(estado=='MX09')
{var delegacion=WA.toDOM('delegacion_envio').value;if(!delegacion)
{statusestado=false;errorform('delegacion_envio',WA.i18n.getMessage("txtpventa29"));}
else
limpiacampo('delegacion_envio');}
else
{delegacion=WA.toDOM('delegacion_input_envio').value;if(!delegacion)
{statusestado=false;errorform('delegacion_envio',WA.i18n.getMessage("txtpventa29"));}
else
limpiacampo('delegacion_envio');var ciudad=WA.toDOM('ciudad_envio').value;if(!ciudad_envio)
{errorform('ciudad_envio',WA.i18n.getMessage("txtpventa30"));statusestado=false;}
else
limpiacampo('ciudad_envio');}
estatusformdireccion=statusestado&&calle_envio.status&&numext_envio.status&&ciudad_envio.status&&colonia_envio.status&&codigopostal_envio.status&&telefono_envio.status;activarBotonGlobal();return true;}
catch(e)
{ga('send','event','compra','error/condireccioncheck','pc/99',null);if(KL.devel)
console.log('condireccioncheck  '+e);KL.manageError(e);}}
function activarBotonGlobal()
{if(condireccion)
globalstatus=estatusformpago&&estatusformbasico&&estatusformdireccion;else
globalstatus=estatusformpago&&estatusformbasico;WA.toDOM('botoncompraproducto').style.backgroundColor=globalstatus?'#8cc63e':'#aaaaaa';WA.toDOM('botoncompraproducto').disabled=!globalstatus;}
function errorform(id,msg)
{WA.toDOM(id).className='error-campo';WA.toDOM(id+'msg').innerHTML=msg;WA.toDOM(id+'msg').style.display='';}
function limpiacampo(id)
{WA.toDOM(id).className='';WA.toDOM(id+'msg').innerHTML='';WA.toDOM(id+'msg').style.display='none';}
var hrFlotanteClose=false;function barraFlotante()
{try
{var scrollLocation=WA.browser.getScrollTop();if(scrollLocation>30)
{WA.toDOM('div_didi_flotante').style.display="block";}
else
{WA.toDOM('div_didi_flotante').style.display="none";}}
catch(e)
{ga('send','event','compra','error/payment','pc/99',null);if(KL.devel)
console.log('barraFlotante  '+e);KL.manageError(e);}}
var condireccion=false;function loadproducto()
{try
{if(WA.toDOM('formulario-pago'))
{loadexterncode("//secure.mlstatic.com/sdk/javascript/v1/mercadopago.js",null,getMP);if(WA.toDOM('Estado'))
{condireccion=true;console.log("con direccion "+condireccion);startformdatosbasicos();startformcondireccion();}
else
startformdatosbasicos();if(WA.toDOM('total_producto'))
{var montototal=parseFloat(WA.toDOM('total_producto').innerHTML);WA.toDOM('total_producto').innerHTML=formatearDinero(montototal);if(WA.toDOM('total_producto_resumen1'))
{WA.toDOM('total_producto_resumen1').innerHTML=formatearDinero(montototal);}
if(WA.toDOM('total_producto_resumen'))
{WA.toDOM('total_producto_resumen').innerHTML=formatearDinero(montototal);}}
getcompra();var fecha=new Date();fecha.setDate(fecha.getDate()+15);if(WA.toDOM('fecha_envio_previo'))
WA.toDOM('fecha_envio_previo').innerHTML=fecha.getDate()+'/'+(fecha.getMonth()+1)+'/'+fecha.getFullYear();window.scrollTo(0,0);WA.Managers.event.on('scroll',window,scrollbarraflotante,true);}
else if(WA.toDOM('botoncompartirrecetarios'))
{startcompartirrecetario();}
else return;}
catch(e)
{ga('send','event','compra','error/loadproducto','pc/99',null);if(KL.devel)
console.log('loadproducto  '+e);KL.manageError(e);}}
function scrollbarraflotante(event)
{try
{var node1=WA.toDOM('div_didi_flotante');if(!node1)
return;var scrolllocation1=WA.browser.getScrollTop();if(scrolllocation1<421)
{node1.style.display="block";node1.style.top=-200+'px';}
else
node1.style.top=55+'px';}
catch(e)
{ga('send','event','compra','error/scrollbarraflotante','pc/99',null);if(KL.devel)
console.log('scrollbarraflotante  '+e);KL.manageError(e);}}
var compartirready=false;var mail1=null;var mail2=null;var mail3=null;function startcompartirrecetario()
{ga('send','event','share','info/startcompartirrecetario','pc/ok',null);if(compartirready)
return;try
{mail1=new validator.textfield('mail1',{maxlength:250,notempty:false,format:emailformato},'mail1msg',compartirrecetariocheck);mail2=new validator.textfield('mail2',{maxlength:250,notempty:true,format:emailformato},'mail2msg',compartirrecetariocheck);mail3=new validator.textfield('mail3',{maxlength:250,notempty:true,format:emailformato},'mail3msg',compartirrecetariocheck);compartirready=true;compartirrecetariocheck();}
catch(e)
{if(KL.devel)
console.log('startcompartirrecetario  '+e);ga('send','event','share','error/startcompartirrecetario','pc/99',null);KL.manageError(e);}}
this.compartirrecetariocheck=compartirrecetariocheck;function compartirrecetariocheck()
{if(!compartirready)
return;try
{if(!mail1.status&&mail1.blurred)
{var mail_1=WA.toDOM('mail1').value;if(!mail_1||mail_1=='')
errorform('mail1',WA.i18n.getMessage("txtpventa32"));else
errorform('mail1',WA.i18n.getMessage("txtpventa33"));}
else
limpiacampo('mail1');if(!mail2.status&&mail2.blurred)
{var mail_2=WA.toDOM('mail2').value;if(!mail_2||mail_2=='')
errorform('mail2',WA.i18n.getMessage("txtpventa32"));else
errorform('mail2',WA.i18n.getMessage("txtpventa33"));}
else
limpiacampo('mail2');if(!mail3.status&&mail3.blurred)
{var mail_3=WA.toDOM('mail3').value;if(!mail_3||mail_3=='')
errorform('mail3',WA.i18n.getMessage("txtpventa32"));else
errorform('mail3',WA.i18n.getMessage("txtpventa33"));}
else
limpiacampo('mail3');botoncompartir=mail1.status||mail2.status||mail3.status;WA.toDOM('botoncompartirrecetarios').style.backgroundColor=botoncompartir?'#8cc63e':'#aaaaaa';WA.toDOM('botoncompartirrecetarios').disabled=!botoncompartir;return true;}
catch(e)
{if(KL.devel)
console.log('compartirrecetariocheck  '+e);ga('send','event','share','error/compartirrecetariocheck','pc/99',null);KL.manageError(e);}}
this.compartirRecetario=compartirRecetario;function compartirRecetario(recetario)
{mail1=WA.toDOM('mail1').value;if(!mail1)
mail1='';mail2=WA.toDOM('mail2').value;if(!mail2)
mail2='';mail3=WA.toDOM('mail3').value;if(!mail3)
mail3='';var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/sendmail','POST',null,getcompartirRecetario,false);request.addParameter('correo1',mail1);request.addParameter('correo2',mail2);request.addParameter('correo3',mail3);request.send();}
function getcompartirRecetario(request)
{var respuesta=WA.JSON.decode(request.responseText);alerta(respuesta.mensaje,WA.i18n.getMessage("txtpventa34"));compartirready=false;startcompartirrecetario();}
this.copiarlink=copiarlink;function copiarlink()
{var copyText=WA.toDOM("comparte_linkrecetarios");document.execCommand("Copy");alert(WA.i18n.getMessage("txtpventa35"));}
this.switchformulario=switchformulario;function switchformulario()
{var formulariopago=WA.toDOM('formulario-pago');var licuadoramain=WA.toDOM('licuadora-main');if(licuadoramain)
{if(licuadoramain.style.display=='none')
{licuadoramain.style.display='block';mostrarHeader();}
else
{licuadoramain.style.display='none';}}
if(formulariopago.style.display=='none')
{formulariopago.style.display='block';ocualtarHeader();}
else
{formulariopago.style.display='none';}
window.scrollTo(0,0);}
this.agregarCantidadCompralicuadora=agregarCantidadCompralicuadora;function agregarCantidadCompralicuadora(menos,mas)
{var cantidadresumen=WA.toDOM('cantidad_producto_resumen');var cantidadresumen1=WA.toDOM('cantidad_producto_resumen1');var cantidad=WA.toDOM('cantidad_producto');var totaldiv=WA.toDOM('total_producto');var totalresumen=WA.toDOM('total_producto_resumen');var totalresumen1=WA.toDOM('total_producto_resumen1');var actual=cantidadresumen.innerHTML;var cantidadtxt=WA.toDOM('cantidad_producto_txt');actual.trim();actual++;var precio=WA.toDOM('precio_producto').innerHTML;var total=precio*actual;var totalformteado=formatearDinero(total);if(cantidad)
cantidad.innerHTML=actual;if(cantidadresumen)
cantidadresumen.innerHTML=actual;if(cantidadresumen1)
cantidadresumen1.innerHTML=actual;if(totalresumen)
totalresumen.innerHTML=totalformteado;if(totalresumen1)
totalresumen1.innerHTML=totalformteado;if(cantidadtxt)
cantidadtxt.innerHTML=actual;if(totaldiv)
totaldiv.innerHTML=totalformteado;}
this.quitarCantidadCompralicuadora=quitarCantidadCompralicuadora;function quitarCantidadCompralicuadora()
{var cantidadresumen=WA.toDOM('cantidad_producto_resumen');var cantidadresumen1=WA.toDOM('cantidad_producto_resumen1');var cantidad=WA.toDOM('cantidad_producto');var totaldiv=WA.toDOM('total_producto');var totalresumen=WA.toDOM('total_producto_resumen');var totalresumen1=WA.toDOM('total_producto_resumen1');var cantidadtxt=WA.toDOM('cantidad_producto_txt');var actual=cantidadresumen.innerHTML;actual.trim();actual--;if(actual<=0)
actual=1;var precio=WA.toDOM('precio_producto').innerHTML;var total=precio*actual;var totalformteado=formatearDinero(total);if(cantidad)
cantidad.innerHTML=actual;if(cantidadresumen)
cantidadresumen.innerHTML=actual;if(cantidadresumen1)
cantidadresumen1.innerHTML=actual;if(totalresumen)
totalresumen.innerHTML=totalformteado;if(totalresumen1)
totalresumen1.innerHTML=totalformteado;if(cantidadtxt)
cantidadtxt.innerHTML=actual;if(totaldiv)
totaldiv.innerHTML=totalformteado;}
this.muestraformulariopago=muestraformulariopago;function muestraformulariopago()
{var formulariopago=WA.toDOM('formulario-pago');if(formulariopago)
formulariopago.style.display='block';}
this.ocultaformulariopago=ocultaformulariopago;function ocultaformulariopago()
{var formulariopago=WA.toDOM('formulario-pago');if(formulariopago)
formulariopago.style.display='none';}
this.ocualtarHeader=ocualtarHeader;function ocualtarHeader()
{try
{var menu=WA.toDOM('header-menu-receta');var idioma=WA.toDOM('header-idioma');var buscar=WA.toDOM('header-buscar');var usuario=WA.toDOM('header-usuario');var usuariofoto=WA.toDOM('header-user');var logo=WA.toDOM('header-logo');var nologeado=WA.toDOM('header-sociallogin');var atrasdiv=document.createElement('div');atrasdiv.setAttribute("id","atras-header");var headerprincipal=WA.toDOM('header-up');if(menu)
menu.style.display='none';if(idioma)
idioma.style.display='none';if(buscar)
buscar.style.display='none';if(usuario)
usuario.style.display='none';if(usuariofoto)
usuariofoto.style.display='none';if(nologeado)
usuariofoto.style.display='none';if(logo)
logo.style='float:none; margin: auto;';var txtregresar=document.createTextNode('Regresar');var atrastxt=WA.createDomNode('span','regresa_menu_normal','icon-k5-flecha-linea-izq');atrasdiv.setAttribute("id","atras-header");atrasdiv.addEventListener('click',switchformulario);atrasdiv.className='divcontregresar';atrasdiv.appendChild(atrastxt);atrasdiv.appendChild(txtregresar);headerprincipal.appendChild(atrasdiv);}
catch(e)
{ga('send','event','compra','error/ocualtarHeader','pc/99',null);console.log('ocualtarHeader  '+e);KL.manageError(e);}}
this.mostrarHeader=mostrarHeader;function mostrarHeader()
{try
{var menu=WA.toDOM('header-menu-receta');var idioma=WA.toDOM('header-idioma');var buscar=WA.toDOM('header-buscar');var usuario=WA.toDOM('header-usuario');var usuariofoto=WA.toDOM('header-user');var logo=WA.toDOM('header-logo');var nologeado=WA.toDOM('header-sociallogin');var atras=WA.toDOM("atras-header");if(menu)
menu.style.display='block';if(idioma)
idioma.style.display='block';if(buscar)
buscar.style.display='block';if(usuario)
usuario.style.display='block';if(usuariofoto)
usuariofoto.style.display='block';if(nologeado)
usuariofoto.style.display='block';if(logo)
logo.style='';if(atras)
{var padre=atras.parentNode;padre.removeChild(atras);}}
catch(e)
{ga('send','event','compra','error/mostrarHeader','pc/99',null);console.log('mostrarHeader  '+e);KL.manageError(e);}}
this.actualizanombre=actualizanombre;function actualizanombre()
{try
{var nombreformulario=WA.toDOM('nombre_envio');if(nombreformulario)
{nombre=nombreformulario.value;nombrecorto=nombre.split(" ");if(WA.toDOM('nombre-gracias'))
WA.toDOM('nombre-gracias').innerHTML=nombrecorto[0];}}
catch(e)
{ga('send','event','compra','error/actualizanombre','pc/99',null);console.log('actualizanombre  '+e);KL.manageError(e);}}
this.enviocheckar=enviocheckar;function enviocheckar()
{try
{return true;}
catch(e)
{ga('send','event','compra','error/enviocheckar','pc/99',null);KL.manageError(e);}}
this.creaNumeroDePedido=creaNumeroDePedido;function creaNumeroDePedido(clave)
{try
{var now=new Date();var start=new Date(now.getFullYear(),0,0);var diff=now-start;var oneDay=1000*60*60*24;var day=Math.floor(diff/oneDay);var numeropedido='18'+day+'-00'+clave;return numeropedido;}
catch(e)
{ga('send','event','compra','error/creaNumeroDePedido','pc/99',null);KL.manageError(e);}}
this.validarmail=validarmail;function validarmail(clave)
{try
{console.log('Validando mail');}
catch(e)
{ga('send','event','compra','error/validarmail','pc/99',null);KL.manageError(e);}}
this.actualizacorreoproducto=actualizacorreoproducto;function actualizacorreoproducto(clave)
{try
{var correo=WA.toDOM('correonuevorecetario');if(correo)
{console.log(correo.value);var request=WA.Managers.ajax.createRequest(KL.identitydomains+'/actualizar','POST',null,responsecorreonuevo,false);request.addParameter('orden','actualizarcorreo');request.addParameter('correo',correo.value);request.addParameter('clave',clave);request.send();}}
catch(e)
{ga('send','event','compra','error/actualizacorreoproducto','pc/99',null);KL.manageError(e);}}
function responsecorreonuevo(request)
{try
{respuesta=WA.JSON.decode(request.responseText);if(respuesta.estatus=='Error')
alert(respuesta.mensaje);if(respuesta.estatus=='OK')
registrarGratuito(respuesta.clave,respuesta.correo)}
catch(e)
{ga('send','event','compra','error/actualizacorreoproducto','pc/99',null);KL.manageError(e);}}
WA.Managers.event.on('load',window,loadproducto,true);}
var filtro_estatus=false;function filtro_openclose()
{if(filtro_estatus)
WA.toDOM('busca-izquierda').className='cerrado anim';else
WA.toDOM('busca-izquierda').className='abierto anim';filtro_estatus=!filtro_estatus;}
var vista_lista_receta='ficha';var pagina_lista_receta=1;function enviabuscar(pagina)
{if(!pagina)
pagina_lista_receta=1;if(WA.toDOM('f_buscar_q')&&pagina_lista_receta==1)
{var q=WA.toDOM('f_buscar_q').value;WA.toDOM('f_buscar').submit();}
else if(WA.toDOM('q'))
var q=WA.toDOM('q').value;var filters=getFiltrosObject(pagina);var order=filters.ordena;var multimedia=1;if(filters.convideo)
multimedia=3;else if(filters.confoto)
multimedia=2;var recipeclassifications=filters.cats.concat(filters.coc);var request=WA.Managers.ajax.createRequest(KL.grdomains+'/v6/search','POST','',getquerybuscar,false);request.addParameter('q',filters.q);request.addParameter('page',pagina_lista_receta);request.addParameter('language',KL.language);request.addParameter('human',0);request.addParameter('device','pc');request.addParameter('order',order);request.addParameter('multimedia',multimedia);request.addParameter('quantity',16);request.addParameter('recipeclassification',recipeclassifications);request.send();ga('send','event','pagina','pag/buscar','pag/bus/carga',0);return;var request=WA.Managers.ajax.createRequest(KL.grdomains+'/v6/search','POST','',getquerybuscar,false);request.addParameter('q',q);request.addParameter('device','pc');request.addParameter('language',KL.language);request.addParameter('page',pagina_lista_receta);request.addParameter('quantity',10);request.addParameter('human',0);request.send();ga('send','event','pagina','pag/buscar','pag/bus/carga',0);}
function getquerybuscar(request)
{var resultData=JSON.parse(request.responseText)||{};if(pagina_lista_receta==1)
{window.scrollTo(0,0);if(WA.toDOM('buscardiv_resultado'))
WA.toDOM('buscardiv_resultado').innerHTML='';KL.Modules.feed.destruir('buscardiv_resultado');KL.Modules.feed.crear('buscardiv_resultado','feed',true,request.responseText);}else{if(resultData.payload&&resultData.payload.length>0)
{KL.Modules.feed.agregar('buscardiv_resultado','feed',true,request.responseText);WA.toDOM('pagebody').style.top=-scrolllocationbusqueda+'px';}}}
function enviabuscarfiltro(pagina)
{var mostrar;var confoto=false;var convideo=false;var tipobusqueda='google';if(!pagina)
pagina_lista_receta=1;WA.toDOM('filtros_actuales').innerHTML='';esconderopciones('tipo');esconderopciones('tecnicas');esconderopciones('alergias');esconderopciones('dietas');var q=WA.toDOM('q').value;var mostrar=WA.toDOM('mostrar').value;if(mostrar=='confoto')
{confoto=true;}
else if(mostrar=='convideo')
{convideo=true;}
else
{confoto=false;convideo=false;}
var ordena=WA.toDOM('ordena').value;var nodes=document.getElementsByClassName('tecnicas');var cats=[];for(var id=0;id<nodes.length;id++)
{if(nodes[id].checked)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_'+nodes[id].id+'" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\''+nodes[id].id+'\');" ></div> <label>'+WA.toDOM(nodes[id].id).name+'</label> </div>';cats.push(nodes[id].value);}}
var coc=[];nodes=document.getElementsByClassName('tipococina');for(var id=0;id<nodes.length;id++)
{if(nodes[id].checked)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_'+nodes[id].id+'" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\''+nodes[id].id+'\');"></div> <label>'+WA.toDOM(nodes[id].id).name+'</label> </div>';coc.push(nodes[id].value);}}
var diabetes=WA.toDOM('diabetes').checked;if(diabetes)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_diabetes" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'diabetes\');"> </div><label>'+WA.toDOM('diabetes').name+'</label></div>';var diabetes=WA.toDOM('vegetariano').checked;if(diabetes)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_vegetariano" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'vegetariano\');"> </div><label>'+WA.toDOM('vegetariano').name+'</label></div>';var diabetes=WA.toDOM('ovolacteo').checked;if(diabetes)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_ovolacteo" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'ovolacteo\');"> </div><label>'+WA.toDOM('ovolacteo').name+'</label></div>';var diabetes=WA.toDOM('vegano').checked;if(diabetes)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_vegano" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'vegano\');"> </div><label>'+WA.toDOM('vegano').name+'</label></div>';var gluten=WA.toDOM('gluten').checked;if(gluten)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_gluten" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'gluten\');"> </div><label>'+WA.toDOM('gluten').name+'</label></div>';var soya=WA.toDOM('soya').checked;if(soya)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_soya" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'soya\');"> </div><label>'+WA.toDOM('soya').name+'</label></div>';var mariscos=WA.toDOM('mariscos').checked;if(mariscos)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_mariscos" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'mariscos\');"> </div><label>'+WA.toDOM('mariscos').name+'</label></div>';var nueces=WA.toDOM('nueces').checked;if(nueces)
WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_nueces" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'nueces\');"> </div><label>'+WA.toDOM('nueces').name+'</label></div>';var filters=getFiltrosObject(pagina);var order=filters.ordena;var multimedia=1;if(filters.convideo)
multimedia=3;else if(filters.confoto)
multimedia=2;var recipeclassifications=filters.cats.concat(filters.coc,filters.dietasclassifications);var request=WA.Managers.ajax.createRequest(KL.grdomains+'/v6/search','POST','',getquerybuscar,false);request.addParameter('q',filters.q);request.addParameter('page',pagina_lista_receta);request.addParameter('language',KL.language);request.addParameter('human',0);request.addParameter('device','pc');request.addParameter('order',order);request.addParameter('multimedia',multimedia);request.addParameter('quantity',12);request.addParameter('recipeclassification',recipeclassifications);request.addParameter('allergies',filters.allergies);request.send();ga('send','event','pagina','pag/buscar','pag/bus/carga',0);}
function getFiltrosObject(pagina)
{var mostrar;var confoto=false;var convideo=false;var tipobusqueda='google';if(!pagina)
pagina_lista_receta=1;WA.toDOM('filtros_actuales').innerHTML='';esconderopciones('tipo');esconderopciones('tecnicas');esconderopciones('alergias');esconderopciones('dietas');var q=WA.toDOM('q').value;var mostrar=WA.toDOM('mostrar').value;if(mostrar=='confoto')
{confoto=true;}
else if(mostrar=='convideo')
{convideo=true;}
else
{confoto=false;convideo=false;}
var ordena=WA.toDOM('ordena').value;var nodes=document.getElementsByClassName('tecnicas');var cats=[];for(var id=0;id<nodes.length;id++)
{if(nodes[id].checked)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_'+nodes[id].id+'" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\''+nodes[id].id+'\');" ></div> <label>'+WA.toDOM(nodes[id].id).name+'</label> </div>';cats.push(nodes[id].value);}}
var coc=[];nodes=document.getElementsByClassName('tipococina');for(var id=0;id<nodes.length;id++)
{if(nodes[id].checked)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_'+nodes[id].id+'" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\''+nodes[id].id+'\');"></div> <label>'+WA.toDOM(nodes[id].id).name+'</label> </div>';coc.push(nodes[id].value);}}
var dietasClassifications=[];var diabetes=WA.toDOM('diabetes').checked;if(diabetes)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_diabetes" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'diabetes\');"> </div><label>'+WA.toDOM('diabetes').name+'</label></div>';dietasClassifications.push(3011,3193);}
var vegetariano=WA.toDOM('vegetariano').checked;if(vegetariano)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_vegetariano" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'vegetariano\');"> </div><label>'+WA.toDOM('vegetariano').name+'</label></div>';dietasClassifications.push(3705,4015,3204,3260,3200,3530,3877);}
var ovolacteo=WA.toDOM('ovolacteo').checked;if(ovolacteo)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_ovolacteo" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'ovolacteo\');"> </div><label>'+WA.toDOM('ovolacteo').name+'</label></div>';dietasClassifications.push(3705,3204,3260,3530,3877,3200);}
var vegano=WA.toDOM('vegano').checked;if(vegano)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_vegano" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'vegano\');"> </div><label>'+WA.toDOM('vegano').name+'</label></div>';dietasClassifications.push(3895,3900,3902,3903,3209);}
var allergiesStr="";var gluten=WA.toDOM('gluten').checked;if(gluten)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_gluten" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'gluten\');"> </div><label>'+WA.toDOM('gluten').name+'</label></div>';allergiesStr+="1"}
var soya=WA.toDOM('soya').checked;if(soya)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_soya" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'soya\');"> </div><label>'+WA.toDOM('soya').name+'</label></div>';allergiesStr+=(allergiesStr===""?'':',')+"2";}
var mariscos=WA.toDOM('mariscos').checked;if(mariscos)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_mariscos" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'mariscos\');"> </div><label>'+WA.toDOM('mariscos').name+'</label></div>';allergiesStr+=(allergiesStr===""?'':',')+"3";}
var nueces=WA.toDOM('nueces').checked;if(nueces)
{WA.toDOM('filtros_actuales').innerHTML+='<div id="etiqueta_nueces" class="etiquetafiltro"> <div class="cierrafiltroetiqueta" onclick="cierraetiqueta(\'nueces\');"> </div><label>'+WA.toDOM('nueces').name+'</label></div>';allergiesStr+=(allergiesStr===""?'':',')+"4";}
return{q:q,mostrar:mostrar,confoto:confoto,convideo:convideo,ordena:ordena,cats:cats,coc:coc,diabetes:diabetes,gluten:gluten,soya:soya,mariscos:mariscos,nueces:nueces,allergies:allergiesStr,dietasclassifications:dietasClassifications};}
function getquerybuscarfiltro(request)
{if(pagina_lista_receta==1)
{WA.toDOM('resultado_contenido').innerHTML=request.responseText;}
else
{WA.toDOM('resultado_contenido').innerHTML+=request.responseText;}
cargaImagenes('postload');verificabuscadatos();}
function reiniciabuscar()
{alert('reinicia buscar');}
function verificabuscadatos()
{var node=WA.toDOM('buscacantidad');if(node)
{WA.toDOM('buscacantidadresultados').innerHTML=node.innerHTML;}
else
WA.toDOM('buscacantidadresultados').innerHTML=WA.i18n.getMessage("txtverificabuscadatos1");var node=WA.toDOM('buscatiempo');if(node)
{WA.toDOM('buscatiemporesultados').innerHTML=WA.i18n.getMessage("txtverificabuscadatos2")+' '+node.innerHTML+WA.i18n.getMessage("txtverificabuscadatos3");}
else
WA.toDOM('buscatiemporesultados').innerHTML='';}
function recarga_receta(param)
{if(param=='listaizq'||param=='ficha')
{if(vista_lista_receta==param)
return;WA.toDOM('recetaselector_'+vista_lista_receta).className=vista_lista_receta;vista_lista_receta=param;WA.toDOM('recetaselector_'+param).className=param+' on';}
enviabuscar();}
var scrolllocationbusqueda;function vermas()
{pagina_lista_receta++;scrolllocationbusqueda=WA.browser.getScrollTop();enviabuscar(true);}
function teclaEnter(e)
{if(e.keyCode==13)
enviabuscar(true);}
var filtroabierto=false;function mostraropciones(id)
{if(!filtroabierto)
{WA.toDOM('filtro-'+id).style.display="block";filtroabierto=true;}
else
esconderopciones(id);}
function esconderopciones(id)
{if(filtroabierto)
{WA.toDOM('filtro-'+id).style.display="none";filtroabierto=false;}}
function cierraetiqueta(id)
{WA.toDOM('etiqueta_'+id).parentNode.removeChild(WA.toDOM('etiqueta_'+id));WA.toDOM(id).checked=0;enviabuscarfiltro();}
setTimeout(function(){if(window.location.pathname==="/buscar")
{var preloadedResponse="{}";var responseInputId="searchResultBruteData";var n=document.getElementById(responseInputId);if(n)
preloadedResponse=n.value;var responseObj=JSON.parse(preloadedResponse)||{};if(Object.keys(responseObj).length===0||responseObj.total===0)
{var valorBuscado=WA.toDOM('solobusqueda').value;WA.toDOM('sin_resultados_valor').innerHTML=" "+valorBuscado;WA.toDOM('div_sinresultadobuscar').style.display='block';WA.toDOM('buscardiv_resultado').innerHTML='';return;}
if(pagina_lista_receta==1)
{window.scrollTo(0,0);if(WA.toDOM('buscardiv_resultado'))
WA.toDOM('buscardiv_resultado').innerHTML='';KL.Modules.feed.destruir('buscardiv_resultado');KL.Modules.feed.crear('buscardiv_resultado','feed',true,preloadedResponse);}
else
{KL.Modules.feed.agregar('buscardiv_resultado','feed',true,preloadedResponse);}
n.remove();}},0);var pagina_principal='1';var pagina_lista_articulo=1;var articulosjump=0;var offset1=0;var offsetclasificaciones=2;function vermasarticulos()
{offset1=offset1+6;llamaArticulos(offset1);}
function vermasclasificaciones(idclasificacion)
{offsetclasificaciones=offsetclasificaciones+6;llamaClasificaciones(idclasificacion);}
function llamaClasificaciones(idclasificacion)
{var request=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/articulos','POST','limit=5&offset='+offsetclasificaciones+'&clasificacion1='+idclasificacion,respuestavermasclas,true);request.send();}
function llamaArticulos(offset1)
{var request=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/articulos','POST','limit=5&offset='+offset1,respuestavermas,true);request.send();}
function respuestavermas(respuesta)
{var resp=JSON.parse(respuesta.responseText)
if(resp.estatus==='OK')
{document.getElementById('blogrecientes').innerHTML+=resp.data;nuevooffset=(parseInt(resp.offset))+(6*pagina_lista_articulo);var padre=document.getElementById('blogclasificaciones');var padrevermas=document.getElementById('vermasrecientes').parentNode;var hijo=document.getElementById('vermasrecientes');if(hijo)
padrevermas.removeChild(hijo);var nuevovermas=document.createElement('div');nuevovermas.innerHTML='<div id="vermasrecientes" onclick="vermasarticulos();">Ver más</div>';padre.appendChild(nuevovermas);pagina_lista_articulo++;cargaImagenes('postload');}
else
{var hijo=document.getElementById('vermasrecientes');if(hijo)
padre.removeChild(hijo);}}
function respuestavermasclas(respuesta)
{var resp=JSON.parse(respuesta.responseText)
if(resp.estatus==='OK')
{document.getElementById('blogrecientes').innerHTML+=resp.data;nuevooffset=(parseInt(resp.offset))+(6*pagina_lista_articulo);var padre=document.getElementById('blogclasificaciones');var padrevermas=document.getElementById('vermasrecientes').parentNode;var hijo=document.getElementById('vermasrecientes');if(hijo)
padrevermas.removeChild(hijo);var nuevovermas=document.createElement('div');nuevovermas.innerHTML='<div id="vermasrecientes" onclick="vermasclasificaciones('+resp.clasificacion+');">Ver más</div>';padre.appendChild(nuevovermas);pagina_lista_articulo++;cargaImagenes('postload');}
else
{console.log('En else');var padre=document.getElementById('vermasrecientes').parentNode;var hijo=document.getElementById('vermasrecientes');if(hijo)
padre.removeChild(hijo);}}
KL.Modules.quiz=new function()
{var self=this;this.quizType=null;this.quizClave=null;this.quizContainer=null;this.preguntas=null;this.respuestas=null;this.resultados=null;this.quizSolved=false;this.idxResultado=null;var preguntasResueltas=[];var answersActionSetted=false;var plantillaCargada=false;var requestedPageByTipoLista={};var ORIGIN='kiwipc';var Q_TYPES={multiPregunta:1,unaPregunta:2};var CLASSES_BY_ENTITY={quiz:'contenedor_quizz',pregunta:'quizz_pregunta',respuesta:'quizz_respuesta_txt',resultado:'quizz_resultado',}
var qListTypes=['masnuevo'];var NODE_IDS=['vermasrecientes'];this.load=load;function load()
{if(!document.getElementsByClassName(CLASSES_BY_ENTITY.quiz)||!document.getElementsByClassName(CLASSES_BY_ENTITY.quiz)[0])
return;self.quizContainer=document.getElementsByClassName(CLASSES_BY_ENTITY.quiz)[0];self.quizClave=parseInt(self.quizContainer.id.split("-")[2]);self.quizType=parseInt(self.quizContainer.dataset.quizType);self.preguntas=self.quizContainer.getElementsByClassName(CLASSES_BY_ENTITY.pregunta);self.respuestas=self.quizContainer.getElementsByClassName(CLASSES_BY_ENTITY.respuesta);self.resultados=document.getElementsByClassName(CLASSES_BY_ENTITY.resultado);ga('send','event','quiz','quiz/load','open',0);}
function listenerplantillacargada()
{plantillaCargada=true;validaBotonVerMas();self.getMoreQuizzes(qListTypes[0]);}
function validaBotonVerMas()
{var verMasButton=document.getElementById(NODE_IDS[0]);if(verMasButton.dataset.hasMore=="1")
verMasButton.style.display="block";else
verMasButton.style.display="none";}
this.validaQuiz=validaQuiz;function validaQuiz()
{if(self.quizSolved)
return false;return true;}
this.setAnswer=setAnswer;function setAnswer(clickedAnswer)
{if(!answersActionSetted)
setAnswersAction(parseInt(clickedAnswer));}
function setAnswersAction(clickedAnswer)
{for(var i=0;i<self.respuestas.length;i++)
{var respuesta=self.respuestas[i];var respuestaClave=parseInt(respuesta.id.split("-")[4]);respuesta.onclick=answerAction;if(respuestaClave===clickedAnswer)
respuesta.onclick();}
answersActionSetted=true;}
function answerAction()
{if(self.quizSolved)
{scrollToResultado(self.idxResultado);return;}
var preguntaClave=this.id.split("-")[2];var respuestaClave=this.id.split("-")[4];switch(self.quizType)
{case Q_TYPES.unaPregunta:var newInputStatus=!WA.toDOM('checkitem_'+respuestaClave).checked;WA.toDOM('checkitem_'+respuestaClave).checked=newInputStatus;WA.toDOM('check_'+respuestaClave).style.color=(newInputStatus?'#f76d85':'#333333');break;case Q_TYPES.multiPregunta:var respuestas=getRespuestasByPregunta(preguntaClave);for(var i=0;i<respuestas.length;i++)
{var respuesta=respuestas[i];if(respuesta.id===this.id)
{if(this.classList.contains('activado'))
{this.classList.remove('activado');removePreguntaResuelta(preguntaClave);}
else
{this.classList.add('activado');addPreguntaResuelta(preguntaClave);var searchedPregunta=getPreguntaByClave(preguntaClave);if(searchedPregunta)
self.scrollToPregunta((searchedPregunta.idx+1));}}
else
{if(respuesta.classList.contains('activado'))
respuesta.classList.remove('activado');}}
sendQuizIfItsComplete();break;default:console.log('Quiz type not recognized',self.quizType);}}
function getPreguntaByClave(clave)
{var result={};var founded=false;for(var i=0;i<self.preguntas.length;i++)
{var pregunta=self.preguntas[i];var preguntaClave=pregunta.id.split("-")[2];if(clave===preguntaClave)
{result.idx=i;result.node=pregunta;founded=true;break;}}
return(founded?result:false);}
function removePreguntaResuelta(clave)
{if(preguntasResueltas.includes(clave))
{preguntasResueltas=preguntasResueltas.filter(function(value,index,arr)
{return value!==clave;});}}
function addPreguntaResuelta(clave)
{if(!preguntasResueltas.includes(clave))
preguntasResueltas.push(clave);}
function sendQuizIfItsComplete()
{var quizCompleto=true;for(var i=0;i<self.preguntas.length;i++)
{var pregunta=self.preguntas[i];var preguntaClave=pregunta.id.split("-")[2];if(!preguntasResueltas.includes(preguntaClave))
quizCompleto=false;}
if(quizCompleto)
self.post();}
function getRespuestasByPregunta(clavePregunta)
{var result=[];for(var i=0;i<self.respuestas.length;i++)
{var respuesta=self.respuestas[i];var auxclave=respuesta.id.split("-")[2];if(clavePregunta===auxclave)
result.push(respuesta);}
return result;}
this.post=post;function post()
{if(!self.validaQuiz())
return;var answers=[];var quizError=false;switch(self.quizType)
{case Q_TYPES.unaPregunta:for(var i=0;i<self.respuestas.length;i++)
{var respuesta=self.respuestas[i];var input=respuesta.getElementsByTagName('input')[0];var splittedId=input.id.split("_");if(!(1 in splittedId))
continue;var respuestaClave=splittedId[1];if(input.checked)
answers.push(respuestaClave);}
break;case Q_TYPES.multiPregunta:for(var i=0;i<self.respuestas.length;i++)
{var respuesta=self.respuestas[i];var respuestaClave=respuesta.id.split("-")[4];if(respuesta.classList.contains('activado'))
answers.push(respuestaClave);}
break;default:console.log('Not recognized quiz type: ',self.quizType);quizError=true;}
if(quizError)
return;if(answers.length===0)
answers='no_answers';var request=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/quiz','POST',null,processResultado,false);request.addParameter('clave',self.quizClave);request.addParameter('action','submit');request.addParameter('answers',answers);request.addParameter('origin',ORIGIN);request.send();}
function processResultado(request)
{var json=JSON.parse(request.response);if(!(json!==null)||!(typeof json==='object'))
return;if(json.status==="OK")
{var resultadoToShowClave=json.message.clave;for(var i=0;i<self.resultados.length;i++)
{var resultado=self.resultados[i];var resultadoClave=parseInt(resultado.id.split("-")[4]);resultado.style.display="none";if(resultadoClave===resultadoToShowClave)
{resultado.style.display="block";scrollToResultado(i);self.quizSolved=true;self.idxResultado=i;}}
ga('send','event','quiz','quiz/result','response',0);}
else
{alert("Response status is not 'OK'");}}
var moreQuizzesRequested=false;this.getMoreQuizzes=getMoreQuizzes;function getMoreQuizzes(type)
{if(moreQuizzesRequested)
return;if(!type)
return;var validType=qListTypes.indexOf(type)>-1;if(!validType)
return;if(!plantillaCargada)
{KL.Modules.plantilla.get('quiz',listenerplantillacargada);return;}
requestedPage=2;if(type in requestedPageByTipoLista)
requestedPage=requestedPageByTipoLista[type];var request=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/quiz','POST',null,processMoreQuizzes,false);request.addParameter('action','getlista');request.addParameter('tipolista',type);request.addParameter('page',requestedPage);request.addParameter('origin',ORIGIN);request.send();moreQuizzesRequested=true;}
function processMoreQuizzes(request)
{moreQuizzesRequested=false;var json=JSON.parse(request.response);if(!(json!==null)||!(typeof json==='object'))
return;if(json.status==="OK")
{switch(json.type)
{case qListTypes[0]:var template=WA.templates.quizlista;if(!template)
return;var newChilds=[];for(var qidx=0;qidx<json.data.length;qidx++)
{qdata=json.data[qidx];if(qdata.clave=="ad")
continue;var newChild=document.createElement("div");newChild.className='div_fichaquiz';newChild.innerHTML=template(qdata);newChilds.push(newChild);}
if((newChilds.length>0)&&document.getElementById("quizrecientes"))
{for(var nidx=0;nidx<newChilds.length;nidx++)
{var aux=newChilds[nidx];document.getElementById("quizrecientes").appendChild(aux);}}
if(!json.hasmore)
document.getElementById(NODE_IDS[0]).style.display="none";cargaImagenes('toload');break;}
requestedPage+=1;requestedPageByTipoLista[json.type]=requestedPage;}
else
{alert("Response status is not 'OK'");}}
this.scrollToPregunta=scrollToPregunta;function scrollToPregunta(index)
{scrollToElement(index,self.preguntas);}
function scrollToResultado(index)
{scrollToElement(index,self.resultados);}
function scrollToElement(index,arr)
{if(!(index in arr))
return;var time=750;var headerOffset=80;var topOffset=(WA.browser.getNodeDocumentTop(arr[index])-WA.browser.getScrollTop()-headerOffset);scrollBy(topOffset,time);}
function scrollBy(distance,duration)
{var initialY=WA.browser.getScrollTop();var y=initialY+distance;var baseY=(initialY+y)*0.5;var difference=initialY-baseY;var startTime=performance.now();function step(){var normalizedTime=(performance.now()-startTime)/duration;if(normalizedTime>1)normalizedTime=1;window.scrollTo(0,baseY+difference*Math.cos(normalizedTime*Math.PI));if(normalizedTime<1)window.requestAnimationFrame(step);}
window.requestAnimationFrame(step);}
this.reloadQuiz=reloadQuiz;function reloadQuiz()
{window.scrollTo(0,0);location.reload();}
this.getPlantillas=getPlantillas;function getPlantillas()
{KL.Modules.plantilla.get('quiz',null);plantillaCargada=true;}}
if(window.location.pathname=="/quiz")
setTimeout(KL.Modules.quiz.getPlantillas,2100);else if(window.location.pathname.indexOf("/quiz/")>-1)
setTimeout(KL.Modules.quiz.load,500);KL.Modules.plantilla=new function()
{var self=this;var listaplantillas={};this.get=get;function get(id,listener)
{if(listaplantillas[id])
{return listaplantillas[id].addlistener(listener);}
listaplantillas[id]=new KL.Modules.plantilla.container(id,listener);return false;}}
KL.Modules.plantilla.container=function(id,listener)
{var self=this;this.id=id;this.estatus=false;var listeners=[];if(listener)
listeners.push(listener);this.addlistener=addlistener;function addlistener(listener)
{if(listener)
listeners.push(listener);if(listener&&self.estatus==true)
listener(true);}
function calllisteners()
{for(var i=0,l=listeners.length;i<l;i++)
listeners[i](true);}
function getplantilla(request)
{var s=document.createElement('script');s.type='text/javascript';s.text=request.responseText;document.getElementsByTagName('head')[0].appendChild(s);self.estatus=true;calllisteners();}
var request=WA.Managers.ajax.createRequest('/listeners/getplantilla/js/'+id,'GET',null,getplantilla,true);}
KL.Modules.feed=new function()
{var self=this;var listafeed={};this.crear=crear;function crear(id,template,datos,q)
{if(listafeed[id])
return;listafeed[id]=new KL.Modules.feed.container(id,template,datos,q);}
this.nuevo=nuevo;function nuevo(id)
{feedcontainer=WA.toDOM(id);if(feedcontainer)
KL.Modules.feed.crear(id,'feed',null);listafeed[id].load();}
this.destruir=destruir;function destruir(id)
{if(!listafeed[id])
return;listafeed[id].destruir();delete listafeed[id];}
this.agregar=agregar;function agregar(id,template,datos,q)
{listafeed[id]=new KL.Modules.feed.container(id,template,datos,q);}
this.getFeed=getFeed;function getFeed(id,request)
{listafeed[id].getFeed(request);}
function load()
{if(KL.devel)
console.log('wb-feed-loaded');feedcontainer=WA.toDOM('feedcontainer');if(KL.devel)
{if(feedcontainer)
console.log('wb-feedcontainer-founded',feedcontainer);else
console.log('wb-feedcontainer-NOT-founded',feedcontainer);}
if(feedcontainer)
KL.Modules.feed.crear('feedcontainer','feed',null);for(var i in listafeed)
listafeed[i].load();}
this.unload=unload;function unload()
{for(var i in listafeed)
destruir(i);}
setTimeout(function(){load();},200);}
KL.Modules.feed.container=function(id,template,datos,q)
{var self=this;this.id=id;this.template=template;this.datos=datos;var feedcontainer=null;var GO_FEEDS=["recetaclasificacion","recetafamilia","tipclasificacion","tipfamilia","home","tiphome","recetacompilaciones"];var plantillacargada=false;var feedcargado=false;var code=null;var globalcounter=1;var sufijosporfeed={'feedrecomendado':'r','feedpopular':'p','feednuevo':'n','feedcontainer':'c'}
function rellenafeed()
{var rutaurl=window.location.pathname;var feedcss='normal';if(rutaurl=='/')
feedcss='home';var sufijo=(typeof(sufijosporfeed[self.id])==='undefined'?sufijosporfeed['feedcontainer']:sufijosporfeed[self.id]);try{if(code.payload){for(var i=0,l=code.payload.length;i<l;i++){var nt=WA.templates[self.template+code.payload[i].t];if(!nt)
continue;var np=WA.templates[self.template+'entrada'+code.payload[i].p];if(!np)
np=WA.templates[self.template+'entradanormal'];if(code.payload[i].favs==null)
code.payload[i].favs=0;if(code.payload[i].imagen){code.payload[i].domain=KL.sitedomains;if(code.payload[i].t=='receta'){if(code.payload[i].f==1){code.payload[i].format1x='th5-320x320';code.payload[i].format2x='th5-640x640';}else{code.payload[i].format1x='th5-320x320';code.payload[i].format2x='th5-640x640';}
code.payload[i].imagen1x='recetaimagen/'+code.payload[i].c+'/'+code.payload[i].format1x+'-'+code.payload[i].imagen;code.payload[i].imagen2x='recetaimagen/'+code.payload[i].c+'/'+code.payload[i].format2x+'-'+code.payload[i].imagen;}else if(code.payload[i].t=='tip'){code.payload[i].format1x='th5-320x320';code.payload[i].format2x='th5-640x640';code.payload[i].imagen1x='ss_secreto/'+code.payload[i].c+'/'+code.payload[i].format1x+'-'+code.payload[i].imagen;code.payload[i].imagen2x='ss_secreto/'+code.payload[i].c+'/'+code.payload[i].format2x+'-'+code.payload[i].imagen;}else if(code.payload[i].t=='compilacion'){code.payload[i].format1x='th5-320x320';code.payload[i].format2x='th5-640x640';code.payload[i].imagen1x='menu/'+code.payload[i].c+'/'+code.payload[i].format1x+'-'+code.payload[i].imagen;code.payload[i].imagen2x='menu/'+code.payload[i].c+'/'+code.payload[i].format2x+'-'+code.payload[i].imagen;}}else{code.payload[i].imagen1x='/kiwi5/static/k5-o-320x320.png';code.payload[i].imagen2x='/kiwi5/static/k5-o-320x320.png';}
if(code.payload[i].nombre)
code.payload[i].nombre2x=separarpalabras(code.payload[i].nombre);if(code.payload[i].share){ns=WA.templates[self.template+'socialshare'];var news=ns(code.payload[i]);code.payload[i].social=news;}
code.payload[i].player_button='none';if((code.payload[i].t=='receta'||code.payload[i].t=='tip'||code.payload[i].t=='compilacion')&&code.payload[i].v!=""){code.payload[i].height=code.payload[i].vh?' height: '+code.payload[i].vh+';':'';code.payload[i].player_button='block';}
code.payload[i].sufijo=sufijo;var newt=nt(code.payload[i]);code.payload[i].content=newt;var newp=np(code.payload[i]);var node=WA.createDomNode('div',self.template+'|'+code.payload[i].t+'|'+code.payload[i].x,'feed-container'+' '+code.payload[i].t+' '+feedcss);node.innerHTML=newp;feedcontainer.appendChild(node);}}
if(code.mas){var nodemas=WA.toDOM(self.id+'|vermas');if(!nodemas){var pmas=WA.templates[self.template+'vermas'];pmast=pmas({id:self.id});var nodemas=WA.createDomNode('div',self.id+'|vermas',self.id);nodemas.innerHTML=pmast;}
feedcontainer.pagina=parseInt(code.pagina,10)+1;feedcontainer.appendChild(nodemas);if(WA.toDOM('vermas_'+self.id))
WA.toDOM('vermas_'+self.id).style.display='block';if(q)
WA.toDOM('vermas_'+self.id).onclick=vermasApi;else{if(WA.toDOM('vermas_'+self.id))
WA.toDOM('vermas_'+self.id).onclick=loadnext;}
WA.toDOM('esperar_'+self.id).style.display='none';}
else{var nodemas=WA.toDOM(self.id+'|vermas');if(nodemas)
nodemas.style.display='none';}
loadActions();cargaImagenes('toload');buildAds('adnetwork','replace',KL.adunit,KL.keywords);}
catch(e){console.log('Error en feed js '+e)}}
function loadActions()
{var buttons=document.getElementsByClassName('herramienta-ficha');for(var i=0;i<buttons.length;i++)
{var btn=buttons[i];if(btn.acctionSetted)
{console.log('wb-action-setted',btn);continue;}
setActionToButton(btn);}}
function setActionToButton(btn)
{var action=function(){console.log('wb-default-action');}
if(btn.classList.contains("favoritos"))
{action=agregarfav;}
else if(btn.classList.contains("colecciones"))
{action=agregarlista;}
else if(btn.classList.contains("ls"))
{action=agregarlistasuper;}
else if(btn.classList.contains("cerrar"))
{action=cerrar;}
btn.onclick=action;btn.accionSetted=true;}
function chefloaded()
{if(!KL.Modules.chef.cheflogged)
return;var seguirnodes=document.getElementsByClassName('boton-seguir-chef');if(seguirnodes)
{for(var i=0;i<seguirnodes.length;i++)
{if(seguirnodes[i].getAttribute('chef')==KL.Modules.chef.getClaveChef())
seguirnodes[i].style.display='none';}}
var eliminarnodes=document.getElementsByClassName('elimina_coleccion');if(eliminarnodes)
{for(var i=0;i<eliminarnodes.length;i++)
{if(eliminarnodes[i].getAttribute('chef')!=KL.Modules.chef.getClaveChef())
eliminarnodes[i].style.display='none';}}
var editarnodes=document.getElementsByClassName('edita_nombre_coleccion');if(editarnodes)
{for(var i=0;i<editarnodes.length;i++)
{if(editarnodes[i].getAttribute("chef")==KL.Modules.chef.getClaveChef())
editarnodes[i].style.display='inline-block';}}
if(WA.toDOM('feedcontainer'))
{var tipocontainer=WA.toDOM('feedcontainer').getAttribute("tipo");if(tipocontainer=="cuentamicoleccion")
WA.toDOM('botonbuscar-colecciones').style.display='block';if(tipocontainer=="cuentamiscolecciones")
WA.toDOM('bb-btn-agrega-coleccion').style.display='block';}}
this.loadnext=loadnext;function loadnext()
{feedcontainer=WA.toDOM(self.id);if(feedcontainer&&feedcontainer.pagina)
{if(WA.toDOM('vermas_'+self.id))
WA.toDOM('vermas_'+self.id).style.display='none';if(WA.toDOM('esperar_'+self.id))
WA.toDOM('esperar_'+self.id).style.display='block';feedcontainer.relleno=false;if(self.id)
load(feedcontainer.pagina);}}
this.vermasApi=vermasApi;function vermasApi()
{WA.toDOM('vermas_'+self.id).style.display='none';WA.toDOM('esperar_'+self.id).style.display='block';feedcontainer.relleno=false;KL.Modules.buscar.vermas();}
this.load=load;function load(pagina)
{feedcontainer=WA.toDOM(self.id);if(feedcontainer&&!feedcontainer.relleno)
{feedcontainer.relleno=true;var tipo=feedcontainer.getAttribute("tipo");var subtipo=feedcontainer.getAttribute("subtipo");var clave=feedcontainer.getAttribute("clave");var precarga=feedcontainer.getAttribute("precarga");var q=feedcontainer.getAttribute("q");var c=feedcontainer.getAttribute("c");var feedlang=KL.language||"es";if(GO_FEEDS.indexOf(tipo)>-1)
{var request=WA.Managers.ajax.createRequest(KL.grdomains+'/v6/feed','POST',null,getfeed,false);request.addParameter('device','pc');request.addParameter('language',feedlang);}
else
{var request=WA.Managers.ajax.createRequest(KL.graphdomains+'/v5/gfeed','POST',null,getfeed,false);request.addParameter('dispositivo','pc');request.addParameter('idioma',feedlang);}
request.addParameter('tipo',tipo);request.addParameter('subtipo',subtipo);request.addParameter('clave',clave);request.addParameter('precarga',precarga);request.addParameter('cantidad',12);if(pagina)
request.addParameter('pagina',pagina);if(q)
request.addParameter('q',q);if(c)
request.addParameter('c',c);request.send();}}
this.busqueda=busqueda;function busqueda(busqueda,q)
{feedcargado=true;feedcontainer=WA.toDOM('buscardiv_resultado');if(q)
{code=WA.JSON.decode(q);rellenafeed();}
else
return;}
this.getfeed=getfeed;function getfeed(request)
{feedcontainervalid=WA.toDOM('feedcontainer');if(!feedcontainervalid)
return;code=WA.JSON.decode(request.responseText);feedcargado=true;var q=WA.toDOM('feedcontainer').getAttribute('q');if(q&&code.total==0)
{var path=window.location.pathname;var contenedor=path.split('/');WA.toDOM('busqueda_sin_'+contenedor[2]).style.display='block';}
if(plantillacargada)
rellenafeed();if(WA.toDOM('div_cargandofeedanim'))
WA.toDOM('div_cargandofeedanim').style.display='none';}
function listenerplantillacargada(estatus)
{plantillacargada=true;if(feedcargado)
rellenafeed();if(datos)
busqueda(datos,q);}
this.destruir=destruir;function destruir()
{self.template=null;self.datos=null;self.feedcontainer=null;self.code=null;self=null;}
KL.Modules.plantilla.get('feed',listenerplantillacargada);}
var activenode=null;function full(node)
{if(activenode!=node)
{if(activenode)
activenode.src=activenode.oldsrc;node.oldsrc=node.src;activenode=node;node.src=KL.cdndomain+"/video/btn-fullscreen-hover.png";}
WA.toDOM(contenedorDerecha).style.display='none';WA.toDOM(contenedor.id).className='veinticuatro columnas full';WA.toDOM(contenedorVideo.id).className='veinticuatro columnas videoinfoOriginalFull';WA.toDOM(publicidadSuperior).style.display='block';}
function publicidad(node)
{if(activenode!=node)
{if(activenode)
activenode.src=activenode.oldsrc;node.oldsrc=node.src;activenode=node;node.src=KL.cdndomain+"/video/btn-fullscreen-hover.png";}
WA.toDOM(contenedor.id).className='veinticuatro columnas original';WA.toDOM(contenedorVideo.id).className='catorce columnas videoinfoOriginal';WA.toDOM(contenedorDerecha.id).className='diez columnas';WA.toDOM(contenedorright).style.display='block';WA.toDOM(contenedorrightI).style.display='none';WA.toDOM(btnfullscreen).style.display='block';WA.toDOM(btnpublicidad).style.display='none';WA.toDOM(contenedorDerecha).style.display='block';}
function informacion(node)
{if(activenode!=node)
{if(activenode)
activenode.src=activenode.oldsrc;node.oldsrc=node.src;activenode=node;node.src=KL.cdndomain+"/video/btn-ingredientes-hover.png";}
borrapublicidad();WA.toDOM(ingredientes).style.display='block';WA.toDOM(pasos).style.display='none';WA.toDOM(publicidadSuperior).style.display='block';}
function informacionPasos(node)
{if(activenode!=node)
{if(activenode)
activenode.src=activenode.oldsrc;node.oldsrc=node.src;activenode=node;node.src=KL.cdndomain+"/video/btn-preparacion-hover.png";}
borrapublicidad();WA.toDOM(ingredientes).style.display='none';WA.toDOM(pasos).style.display='block';WA.toDOM(publicidadSuperior).style.display='block';}
function borrapublicidad()
{WA.toDOM(contenedor.id).className='veinticuatro columnas originalinfo';WA.toDOM(contenedorVideo.id).className='catorce columnas videoinfo';WA.toDOM(contenedorDerecha.id).className='diez columnas info2';WA.toDOM(pestanas.id).className='pestanainfo';WA.toDOM(contenedorDerecha).style.display='block';WA.toDOM(contenedorright).style.display='none';WA.toDOM(contenedorrightI).style.display='block';}
function muestraingredientes()
{WA.toDOM(ingredientes).style.display='block';WA.toDOM(pasos).style.display='none';WA.toDOM(actividad).style.display='none';WA.toDOM(pestanaingredientes.id).className='pestana activo';WA.toDOM(pestanapreparacion.id).className='pestana2 inactivo';WA.toDOM(pestanaactividad.id).className='pestana3 inactivo';}
function muestrapreparacion()
{WA.toDOM(ingredientes).style.display='none';WA.toDOM(pasos).style.display='block';WA.toDOM(actividad).style.display='none';WA.toDOM(pestanaingredientes.id).className='pestana inactivo';WA.toDOM(pestanapreparacion.id).className='pestana2 activo';WA.toDOM(pestanaactividad.id).className='pestana3 inactivo';}
function muestraactividad()
{WA.toDOM(ingredientes).style.display='none';WA.toDOM(pasos).style.display='none';WA.toDOM(actividad).style.display='block';WA.toDOM(pestanaingredientes.id).className='pestana inactivo';WA.toDOM(pestanapreparacion.id).className='pestana2 inactivo';WA.toDOM(pestanaactividad.id).className='pestana3 activo';}
function borra()
{var palabra=WA.toDOM('q1').value;if(!palabra||palabra=='')
{}
else
{WA.toDOM(txtBus).style.display='none';}}
KL.Modules.video=new function()
{this.abrir=abrir;function abrir(containerid,videoid,playerid,ruta)
{var rutareceta=ruta;location.href=rutareceta;}}
var val=null;var openFlag=false;var videoFlag=false;var galeriaFlag=false;var fotoINFlag=false;var fotoOUTFlag=false;var bgFlag=false;var idNodoEnVista=null;var formimage=null;function showRecetaLightBox(tipo,event)
{if(tipo=='video')
{ga('send','event','usuario','usu/receta','usu/rec/vervideo',0);showRecetaVideo();videoFlag=true;openFlag=true;setTimeout(function(){videojs("video_1").play();},1000);}
else if(tipo=='galeria')
{ga('send','event','usuario','usu/receta','usu/rec/vergaleria',0);callBlackBg();mostrarContenedores();verGaleria();galeriaFlag=true;bgFlag=true;openFlag=true;}
else if(tipo=='subir-out')
{ga('send','event','usuario','usu/receta','usu/rec/versubirimagen',0);if(switchdiv())
{callBlackBg();fotoOUTFlag=true;bgFlag=true;openFlag=true;}}
else if(tipo=='subir-in')
{switchdiv();fotoINFlag=true;openFlag=true;}
else
{verGaleria(tipo);}
return WA.browser.cancelEvent(event);}
function mostrarContenedores()
{WA.toDOM('tiraimagen-main-titulo').innerHTML=WA.toDOM('nombre-receta').innerHTML;idNodoEnVista=WA.toDOM('tiraimagen-main-imagen').getAttribute("idInicial");WA.toDOM('imagen-tiraimagen-main').style.opacity='1';WA.toDOM('imagen-tiraimagen-main').style.zIndex='1001';WA.toDOM('tiraimagen-rightcontent').style.opacity='1';WA.toDOM('tiraimagen-rightcontent').style.zIndex='1001';WA.toDOM('tiraimagen-tiraimagenes').style.opacity='1';WA.toDOM('tiraimagen-tiraimagenes').style.zIndex='1001';}
function verGaleria(val)
{if(idNodoEnVista)
if(WA.toDOM(idNodoEnVista))
WA.toDOM(idNodoEnVista).style.opacity='.5';else
{checkSiblings();return;}
if(val)
{if(WA.toDOM('loader-innerimgs'))
WA.toDOM('loader-innerimgs').style.opacity='1';if(WA.toDOM('tiraimagen-main-imagen'))
WA.toDOM('tiraimagen-main-imagen').style.opacity='0';if(val=='siguiente'&&galeriaFlag)
{if(WA.toDOM(idNodoEnVista).nextElementSibling)
{WA.toDOM('tiraimagen-main-imagen').src=WA.toDOM(idNodoEnVista).nextElementSibling.firstElementChild.getAttribute("imagengrande");idNodoEnVista=WA.toDOM(idNodoEnVista).nextElementSibling.id;WA.toDOM('chef-imagen-change').innerHTML=WA.toDOM('content-to-change-'+idNodoEnVista).innerHTML;checkSiblings();}}
else if(val=='anterior'&&galeriaFlag)
{if(WA.toDOM(idNodoEnVista).previousElementSibling)
{WA.toDOM('tiraimagen-main-imagen').src=WA.toDOM(idNodoEnVista).previousElementSibling.firstElementChild.getAttribute("imagengrande");idNodoEnVista=WA.toDOM(idNodoEnVista).previousElementSibling.id;WA.toDOM('chef-imagen-change').innerHTML=WA.toDOM('content-to-change-'+idNodoEnVista).innerHTML;checkSiblings();}}
else
{if(WA.toDOM('tiraimagen-main-imagen'))
{WA.toDOM('tiraimagen-main-imagen').src=WA.toDOM(val).firstElementChild.getAttribute("imagengrande");idNodoEnVista=val;WA.toDOM('chef-imagen-change').innerHTML=WA.toDOM('content-to-change-'+idNodoEnVista).innerHTML;checkSiblings();}}}
else
checkSiblings();}
function fullLoad()
{setTimeout(function(){WA.toDOM('loader-innerimgs').style.opacity='0'},.5);setTimeout(function(){WA.toDOM('tiraimagen-main-imagen').style.opacity='1'},.5);}
function callBlackBg()
{WA.toDOM('cerrarid').innerHTML=WA.i18n.getMessage("txtcerrar");WA.toDOM('tiraimagen-bg-black').style.display='block';WA.toDOM('tiraimagen-bg-black').style.zIndex='1000';}
function closeBlackBg()
{WA.toDOM('cerrarid').innerHTML=WA.i18n.getMessage("txtcerrar");WA.toDOM('tiraimagen-bg-black').style.display='none';WA.toDOM('tiraimagen-bg-black').style.zIndex='-10';}
function showRecetaVideo()
{WA.toDOM('video-receta-show').style.left='auto';}
function cerrarVideo()
{WA.toDOM('video-receta-show').style.left='-1000px';videojs("video_1").pause();}
function checkSiblings()
{if(WA.toDOM(idNodoEnVista))
{WA.toDOM(idNodoEnVista).style.opacity='1';if(WA.toDOM(idNodoEnVista).nextElementSibling)
WA.toDOM('galeria-right-arrow').style.display='block';else
WA.toDOM('galeria-right-arrow').style.display='none';if(WA.toDOM(idNodoEnVista).previousElementSibling)
WA.toDOM('galeria-left-arrow').style.display='block';else
WA.toDOM('galeria-left-arrow').style.display='none';}
else
{WA.toDOM('galeria-right-arrow').style.display='none';WA.toDOM('galeria-left-arrow').style.display='none';}}
function switchdiv()
{if(cheflogged)
{WA.toDOM('subir-imagen-receta').style.padding='10px';WA.toDOM('subir-imagen-receta').style.zIndex='1002';WA.toDOM('subir-imagen-receta').style.opacity='1';WA.toDOM('subir-imagen-receta').style.display='block';return true;}
else
{switchpulldown(null,'recetafoto');return false;}}
function cerrarSubirImagen()
{WA.toDOM('subir-imagen-receta').style.padding='0';WA.toDOM('subir-imagen-receta').style.zIndex='-1';WA.toDOM('subir-imagen-receta').style.opacity='0';WA.toDOM('subir-imagen-receta').style.display='none';}
function cerrarTiraImagen()
{WA.toDOM('tiraimagen-tiraimagenes').style.opacity='0';WA.toDOM('tiraimagen-tiraimagenes').style.zIndex='-1';WA.toDOM('tiraimagen-rightcontent').style.opacity='0';WA.toDOM('tiraimagen-rightcontent').style.zIndex='-1';WA.toDOM('imagen-tiraimagen-main').style.opacity='0';WA.toDOM('imagen-tiraimagen-main').style.zIndex='-1';}
function cerrarContenedores(tipoFlag)
{if(!openFlag)
return;if(typeof(tipoFlag)=="undefined"||tipoFlag.charCode==0)
{if(fotoINFlag)
tipoFlag='subir-in';if(fotoOUTFlag)
tipoFlag='subir-out';if(videoFlag)
tipoFlag='video';if(galeriaFlag)
tipoFlag='galeria';}
if(tipoFlag=='video')
{cerrarVideo();videoFlag=false;openFlag=false;}
else if(tipoFlag=='galeria')
{cerrarSubirImagen();cerrarTiraImagen();closeBlackBg();bgFlag=false;fotoINFlag=false;galeriaFlag=false;openFlag=false;idNodoEnVista=null;}
else if(tipoFlag=='subir-out')
{cerrarSubirImagen();closeBlackBg();bgFlag=false;fotoOUTFlag=false;openFlag=false;}
else if(tipoFlag=='subir-in')
{cerrarSubirImagen();fotoINFlag=false;openFlag=false;}}
WA.Managers.event.key('esc',cerrarContenedores);WA.Managers.event.key('left',function(evento,key,type){if(type=='down')showRecetaLightBox('anterior');});WA.Managers.event.key('right',function(evento,key,type){if(type=='down')showRecetaLightBox('siguiente');});function formImage()
{formimage=new ajaximage('subirFoto','IMAGEN');formimage.setAction('/listeners/dorecetaimagen?orden=foto');formimage.setPage('foto');formimage.setLoadingImage(KL.cdndomains+'/kiwi5/static/loading.gif');}
var enviandoimagen=false;function enviarimagen()
{if(enviandoimagen)
{alerta(WA.i18n.getMessage("txtenviarimagen1"));return;}
var campo_valida_imagen=WA.toDOM('IMAGEN_file').value;if(campo_valida_imagen.length>0)
{ga('send','event','usuario','usu/receta','usu/rec/subirimagen',0);WA.toDOM('subirFoto').submit();WA.toDOM('validaImagen').innerHTML=WA.i18n.getMessage("txtenviarchefimagen2");enviandoimagen=true;}
else
{alerta(WA.i18n.getMessage("txtenviarimagen2"));}}
function imagenrespuesta(texto,cerrar)
{enviandoimagen=false;WA.toDOM('validaImagen').innerHTML=WA.i18n.getMessage("txtcerrarSubirfotochef");WA.toDOM('IMAGEN_image').src=KL.cdndomain+'/images/dot.gif';WA.toDOM('IMAGEN').value='';WA.toDOM('IMAGEN_file').value='';alerta(texto);if(cerrar)
cerrarContenedores('galeria');}
function imagenchefrespuesta(texto,cerrar)
{enviandoimagen=false;WA.toDOM('validaChefImagen').innerHTML=WA.i18n.getMessage("txtcerrarSubirfotochef");WA.toDOM('IMAGENCHEF_image').src=KL.cdndomain+'/images/dot.gif';WA.toDOM('IMAGENCHEF_image').value='';WA.toDOM('IMAGENCHEF_file').value='';alerta(texto);if(cerrar)
cerrarContenedores('galeria');}
function showFullComments()
{WA.toDOM('showFullComments').style.display='none';WA.toDOM('comentarios').style.height='auto';WA.toDOM('comments').style.height='auto';}
function checkNoCheck(num,clave)
{if(WA.toDOM('listaingredientes_'+num).checked==true)
{WA.toDOM('listaingredientes_'+num).checked=false;}
else
{WA.toDOM('listaingredientes_'+num).checked=true;}}
function checkmateriales(num,clave)
{if(WA.toDOM('listamateriales_'+num).checked==true)
{WA.toDOM('listamateriales_'+num).checked=false;}
else
{WA.toDOM('listamateriales_'+num).checked=true;}}
function done(clave)
{if(WA.toDOM('paso-'+clave).className=='roundOff')
{WA.toDOM('paso-'+clave).className='roundOn';WA.toDOM('paso_'+clave).style.color='#8DC63F';}
else
{WA.toDOM('paso-'+clave).className='roundOff';WA.toDOM('paso_'+clave).style.color='#7A7A7A';}}
var vpherramientas=false;function muestratipherramientas()
{if(!vpherramientas){WA.toDOM('tip-herramientas-receta').style.display="block";vpherramientas=true;}
else
cierratipherramientas();}
function cierratipherramientas()
{if(vpherramientas){WA.toDOM('tip-herramientas-receta').style.display="none";vpherramientas=false;}}
function CambiaSistemaMetrico(IdSis,clave)
{var req=WA.Managers.ajax.createRequest('/listeners/doingrediente','POST','type=CambiaSistema&IdReceta='+clave+'&SistemaMetrico='+IdSis.value,RestSistemaMetrico,true);}
function RestSistemaMetrico(request)
{var data=WA.JSON.decode(request.responseText);for(var k in data){var da=document.getElementById('Ing_'+k).innerHTML=data[k];}}
function seleccionartodos(status)
{for(var i=1;i<31;i++)
{var xlista=WA.toDOM('listaingredientes_'+i);if(!xlista)
break;xlista.checked=status;}}
function revisaseleccionados()
{for(var i=1;i<=100;i++)
{var xlista=WA.toDOM('listaingredientes_'+i);if(xlista)
{if(xlista.checked==true)
return false;}}}
function compraringredientes()
{var ing=getingredientes();if(ing.length==0)
seleccionartodos(true);ing=getingredientes();if(ing.length>0)
{var request=WA.Managers.ajax.createRequest('/listeners/docomprar','POST','p='+ing,docomprar,true);}}
function getingredientes(preid)
{if(preid==undefined)
preid='';var ing=[];for(var i=1;i<1000;i++)
{var xlista=WA.toDOM(preid+'listaingredientes_'+i);if(!xlista)
break;if(xlista.checked)
ing.push(xlista.value);}
return ing;}
function docomprar(request)
{var i=confirma(WA.i18n.getMessage("txtdocomprar1")+'\n'+WA.i18n.getMessage("txtdocomprar")+'\n'+WA.i18n.getMessage("txtdocomprar3"),WA.i18n.getMessage("txtherramientas1"),WA.i18n.getMessage("txtherramientas2"));{ga('send','event','usuario','usu/receta','usu/rec/compraingredientes',0);WA.toDOM('sup_ing').value=request.responseText;WA.toDOM('test_modal').submit();var request=WA.Managers.ajax.createRequest('/listeners/doreto','POST','orden=superama',null,true);}}
KL.MP={tipovista:'dia',fec_ini:undefined,fec_fin:undefined,fec_seleccionada:0,armaMenu:0,dieta:{},seleccion:undefined}
KL.MP.loader=new function()
{var self=this;var recetaspordias={};var min=1000000;var max=-1000000;var requests=[];this.solicitarinformacion=solicitarinformacion;function solicitarinformacion(fmin,fmax,listener,force)
{if(fmin>=min&&fmax<max&&!force)
{listener(armadatos(fmin,fmax));}
else
{var request=WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','fec_ini='+fmin+'&fec_fin='+fmax,recibeinformacion,true);request.callback=listener;requests.push(request);}}
function recibeinformacion(request)
{try
{var data=JSON.parse(request.responseText);if(data.data)
{for(var p in data.data)
{recetaspordias[p]=data.data[p];}
var fmin=parseInt(data.limites.inicio,10);var fmax=parseInt(data.limites.final,10);if(min>=fmin)
min=fmin;if(max<=fmax)
max=fmax;}
else
{alert(data.mensaje);}
for(var i=0,l=requests.length;i<l;i++)
{if(request==requests[i].request)
{requests[i].callback(armadatos(fmin,fmax));requests.splice(i,1);break;}}}
catch(e)
{alert(e);throw e;}}
this.armadatos=armadatos;function armadatos(fmin,fmax)
{var data={};for(var i=fmin;i<=fmax;i++)
{data[i]=recetaspordias[KL.MP.convierteOffsetAFecha(i)];}
return data;}
this.borrarReceta=borrarReceta;function borrarReceta(clave)
{var found=false;for(var x in recetaspordias)
{for(var y in recetaspordias[x])
{if(recetaspordias[x][y].clave==clave)
{delete recetaspordias[x][y];found=true;break;}}
if(found)
break;}}}();KL.MP.convierteOffsetAFecha=function(offset)
{var fecha=KL.MP.convierteOffsetADate(offset);return fecha.getFullYear()+'-'+KL.pad0(fecha.getMonth()+1)+'-'+KL.pad0(fecha.getDate());}
KL.MP.convierteOffsetADate=function(offset)
{return new Date(new Date().getTime()+(24*60*60*1000)*(offset));}
KL.MP.fabricareceta=function(datos)
{var texto=WA.toDOM('plantilla-receta').innerHTML;if(!datos.ligaimagen)
{if(datos.imagen)
datos.ligaimagen=KL.cdndomain+'/recetaimagen/'+datos.receta+'/thumb150-'+datos.imagen;else
datos.ligaimagen=KL.cdndomain+'/img/static/logo-o-150.png';}
if(datos.dificultad==1)
datos.dificultadtexto=WA.i18n.getMessage("txtplaneador1");else if(datos.dificultad==2)
datos.dificultadtexto=WA.i18n.getMessage("txtplaneador2");else if(datos.dificultad==3)
datos.dificultadtexto=WA.i18n.getMessage("txtplaneador3");for(var p in datos)
texto=texto.replace(new RegExp('\\(\\('+p+'\\)\\)',"g"),datos[p]);var nodo=WA.createDomNode('div','mpreceta|'+datos.clave+'|'+datos.receta,'rec-content-div ');nodo.innerHTML=texto;return nodo;}
KL.MP.fabricarecetaagrega=function(datos)
{var texto=WA.toDOM('plantilla-receta-agrega').innerHTML;if(!datos.ligaimagen)
{if(datos.imagen)
datos.ligaimagen=KL.cdndomain+'/recetaimagen/'+datos.clave+'/thumb90-'+datos.imagen;else
datos.ligaimagen=KL.cdndomain+'/img/static/logo-o-90.png';}
for(var p in datos)
texto=texto.replace(new RegExp('\\(\\('+p+'\\)\\)',"g"),datos[p]);var nodo=WA.createDomNode('div','mprecetaagrega|'+datos.clave,'rec-content-div');nodo.innerHTML=texto;return nodo;}
KL.MP.fabricatipocomida=function(datos)
{var texto=WA.toDOM('plantilla-tipocomida').innerHTML;for(var p in datos)
texto=texto.replace(new RegExp('\\(\\('+p+'\\)\\)',"g"),datos[p]);return texto;}
KL.MP.fabricapelota=function(tipo)
{return WA.createDomNode('div','mp-mes-dia-pelota|'+tipo,'mp-pelota-comidacolor mp-pelota-'+['desayuno','comida','cena','snack','ninguno'][tipo-1]);}
KL.MP.start=function(tipo)
{if(!KL.MP.fec_ini)
{if(tipo=='mes')
{var d=new Date();KL.MP.fec_ini=-d.getDate()+1;KL.MP.fec_fin=KL.MP.fec_ini+WA.Date.getMaxMonthDays(d)-1;}
if(tipo=='semana')
{var d=new Date().getDay();KL.MP.fec_ini=d==6?-6:-d+1;KL.MP.fec_fin=KL.MP.fec_ini+6;}
if(tipo=='dia')
{KL.MP.fec_ini=0;KL.MP.fec_fin=0;}}
KL.MP.cambiaVista(tipo);var Slider=new KL.MP.slidermes('mp-bloque-mes','mp-bloque-dia');Slider.scrolldivision();}
KL.MP.cambiaVista=function(tipo)
{KL.MP.tipovista=tipo;WA.toDOM('content-planeador').setAttribute("view",tipo)
if(tipo=='mes')
{var d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);KL.MP.fec_ini-=d.getDate()-1;KL.MP.fec_fin=KL.MP.fec_ini+WA.Date.getMaxMonthDays(d)-1;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaMes);}
if(tipo=='semana')
{apagarDiaCalendario();var d=KL.MP.convierteOffsetADate(KL.MP.fec_seleccionada).getDay();KL.MP.fec_ini=KL.MP.fec_seleccionada-(d==0?6:d-1);KL.MP.fec_fin=KL.MP.fec_ini+6;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaSemana);}
if(tipo=='dia')
{apagarDiaCalendario();KL.MP.fec_ini=KL.MP.fec_seleccionada
KL.MP.fec_fin=KL.MP.fec_ini;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaDia);}}
KL.MP.slidermes=function(nodeid,nodeidcousin)
{var self=this;this.nodeid=nodeid;this.node=WA.toDOM(this.nodeid);this.nodecousin=WA.toDOM(nodeidcousin);this.scrolldivision=scrolldivision;function scrolldivision(event)
{var scrolllocation=WA.browser.getScrollTop();var cousintop=WA.browser.getNodeNodeTop(self.nodecousin,null);var cousinbottom=cousintop+WA.browser.getNodeOuterHeight(self.nodecousin);var layerheight=WA.browser.getNodeOuterHeight(self.node);if(scrolllocation>cousintop)
{self.node.style.top=(scrolllocation-cousintop+30)+'px';if(scrolllocation>cousinbottom-layerheight)
self.node.style.top=(cousinbottom-cousintop-layerheight)+'px';}
else
self.node.style.top='0';}
WA.Managers.event.on('scroll',window,scrolldivision,true);}
function rellenaDia(datos)
{if(KL.MP.tipovista=='dia')
indice=KL.MP.fec_ini;if(KL.MP.tipovista=='mes')
indice=KL.MP.fec_seleccionada;var d=WA.Date.format(KL.MP.convierteOffsetADate(indice),"l, j")+' '+WA.i18n.getMessage("txtplaneador4")+' '+WA.Date.format(KL.MP.convierteOffsetADate(indice),"F Y");WA.toDOM('mp-dia-dianumero').innerHTML=d;for(var x=1;x<6;x++)
{var texto=KL.MP.fabricatipocomida({clave:x,dia:indice,id:0,icono:mp_tipo_icono[x]});WA.toDOM('mp-dia-'+x).innerHTML=texto;}
if(datos[indice])
{for(var x in datos[indice])
{var node=KL.MP.fabricareceta(datos[indice][x]);WA.toDOM('obj-receta-0-'+datos[indice][x].tipo).appendChild(node);}}
return;}
function irDiaAnterior()
{if(KL.MP.tipovista=='dia')
{KL.MP.fec_ini=KL.MP.fec_ini-1;KL.MP.fec_fin=KL.MP.fec_ini;KL.MP.fec_seleccionada=KL.MP.fec_ini;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaDia);}
else if(KL.MP.tipovista=='mes')
{apagarDiaCalendario();KL.MP.fec_seleccionada--;if(KL.MP.fec_seleccionada<KL.MP.fec_ini)
{irMesAnterior();}
else
{marcaDiaCalendario();KL.MP.loader.solicitarinformacion(KL.MP.fec_seleccionada,KL.MP.fec_seleccionada,rellenaDia);}}}
function irDiaSiguiente()
{if(KL.MP.tipovista=='dia')
{KL.MP.fec_ini=KL.MP.fec_ini+1;KL.MP.fec_fin=KL.MP.fec_ini;KL.MP.fec_seleccionada=KL.MP.fec_ini;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaDia);}
else if(KL.MP.tipovista=='mes')
{apagarDiaCalendario();KL.MP.fec_seleccionada++;if(KL.MP.fec_seleccionada>KL.MP.fec_fin)
{irMesSiguiente();}
else
{marcaDiaCalendario();KL.MP.loader.solicitarinformacion(KL.MP.fec_seleccionada,KL.MP.fec_seleccionada,rellenaDia);}}}
function rellenaSemana(datos)
{var d='';var mesInicio=WA.Date.format(KL.MP.convierteOffsetADate(KL.MP.fec_ini),"F");var mesFin=WA.Date.format(KL.MP.convierteOffsetADate(KL.MP.fec_fin),"F");var fecha=KL.MP.fec_ini;if(mesInicio==mesFin)
d=mesInicio;else
d=mesInicio+' - '+mesFin;WA.toDOM('mp-semana-titulo').innerHTML=d;for(var y=1;y<=7;y++)
{var offset=fecha+y-1;var aux=fecha+KL.MP.agregadia;var d=KL.MP.convierteOffsetADate(offset).getDate();WA.toDOM('mp-semana-dianumero-'+y).innerHTML=d;for(var x=1;x<6;x++)
{var texto=KL.MP.fabricatipocomida({clave:x,dia:offset,id:y,icono:mp_tipo_icono[x]});if(texto)
WA.toDOM('mp-cont-semana-dia-'+y+'-'+x).innerHTML=texto;WA.toDOM('mp-cont-semana-dia-'+y+'-'+x).style.display='none';WA.toDOM('obj-receta-'+y+'-'+x).innerHTML='';}
if(datos[offset])
{for(var x in datos[offset])
{var node=KL.MP.fabricareceta(datos[offset][x]);q=aux+y;WA.toDOM('obj-receta-'+y+'-'+datos[offset][x].tipo).appendChild(node);WA.toDOM('mp-cont-semana-dia-'+y+'-'+datos[offset][x].tipo).style.display='block';}}}}
function irSemanaAnterior()
{KL.MP.fec_ini=KL.MP.fec_ini-7;KL.MP.fec_fin=KL.MP.fec_ini+6;KL.MP.fec_seleccionada-=7;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaSemana);}
function irSemanaSiguiente()
{KL.MP.fec_ini=KL.MP.fec_ini+7;KL.MP.fec_fin=KL.MP.fec_ini+6;KL.MP.fec_seleccionada+=7;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaSemana);}
function rellenaMes(datos)
{var m=WA.Date.format(KL.MP.convierteOffsetADate(KL.MP.fec_ini),"F Y");WA.toDOM('mp-titulo-mes-actual').innerHTML='<div class="img-calendario"></div>'+m;var d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);var num=WA.Date.getMaxMonthDays(d);var offset=d.getDay()==0?7:d.getDay();var totalmes=offset+num;if(totalmes<=36)
WA.toDOM('mp-special-row').style.display='none';else
WA.toDOM('mp-special-row').style.display='table-row';for(var x=1;x<offset;x++)
{WA.toDOM('mp-mes-dia-pos-'+x).innerHTML='';WA.toDOM('mp-mes-dia-pos-'+x).onclick=WA.nothing;}
for(var y=offset;y<offset+num;y++)
{var pointer=KL.MP.fec_ini+y-offset;WA.toDOM('mp-mes-dia-pos-'+y).innerHTML=(y-offset+1)+'<br />';WA.toDOM('mp-mes-dia-pos-'+y).onclick=irDia;WA.toDOM('mp-mes-dia-pos-'+y).indice=pointer;if(datos[pointer])
{var tipos={};for(var x in datos[pointer])
{if(tipos[datos[pointer][x].tipo])
continue;tipos[datos[pointer][x].tipo]=true;}
for(var i=1;i<=5;i++)
{if(tipos[i])
{var node=KL.MP.fabricapelota(i);WA.toDOM('mp-mes-dia-pos-'+y).appendChild(node);}}}}
for(var x=offset+num;x<43;x++)
{WA.toDOM('mp-mes-dia-pos-'+x).innerHTML='';WA.toDOM('mp-mes-dia-pos-'+x).onclick=WA.nothing;}
marcaDiaCalendario();KL.MP.loader.solicitarinformacion(KL.MP.fec_seleccionada,KL.MP.fec_seleccionada,rellenaDia);}
function irMesAnterior()
{KL.MP.fec_fin=KL.MP.fec_ini-1;var d=KL.MP.convierteOffsetADate(KL.MP.fec_fin);var num=WA.Date.getMaxMonthDays(d);apagarDiaCalendario();KL.MP.fec_ini=KL.MP.fec_ini-num;KL.MP.fec_seleccionada-=num;if(KL.MP.fec_seleccionada>KL.MP.fec_fin)
KL.MP.fec_seleccionada=KL.MP.fec_fin;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaMes);}
function irMesSiguiente()
{apagarDiaCalendario();var d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);var numactual=WA.Date.getMaxMonthDays(d);KL.MP.fec_ini=KL.MP.fec_fin+1;d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);var numsiguiente=WA.Date.getMaxMonthDays(d);KL.MP.fec_fin=KL.MP.fec_ini+numsiguiente-1;KL.MP.fec_seleccionada+=numactual;if(KL.MP.fec_seleccionada>KL.MP.fec_fin)
KL.MP.fec_seleccionada=KL.MP.fec_fin;KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaMes);}
function irDia()
{var indice=this.indice;apagarDiaCalendario();KL.MP.fec_seleccionada=indice;marcaDiaCalendario();KL.MP.loader.solicitarinformacion(KL.MP.fec_seleccionada,KL.MP.fec_seleccionada,rellenaDia);}
function marcaDiaCalendario()
{var d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);var offset=d.getDay()==0?6:d.getDay()-1;d=KL.MP.convierteOffsetADate(KL.MP.fec_seleccionada);var numdia=d.getDate();WA.toDOM("mp-mes-dia-pos-"+(offset+numdia)).style.backgroundColor="#F1F1F1";}
function apagarDiaCalendario()
{var d=KL.MP.convierteOffsetADate(KL.MP.fec_ini);var offset=d.getDay()==0?6:d.getDay()-1;var d=KL.MP.convierteOffsetADate(KL.MP.fec_seleccionada);var numdia=d.getDate();WA.toDOM("mp-mes-dia-pos-"+(offset+numdia)).style.backgroundColor="";}
function eliminaRecetaDSM(clave,recetaClave)
{var request=WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=eliminarReceta&clave='+clave+'&recetaclave='+recetaClave,mp_eliminaRecetaDSMRespuesta,true);}
function mp_eliminaRecetaDSMRespuesta(request)
{var resp=WA.JSON.decode(request.responseText);if(resp.estatus=='OK')
{var node=WA.toDOM('mpreceta|'+resp.clave+'|'+resp.clavereceta);var recdataParent=node.parentNode;node.parentNode.removeChild(node);if(KL.MP.tipovista=='semana')
{if(!WA.toDOM(recdataParent).innerHTML)
recdataParent.parentNode.style.display='none';}
KL.MP.loader.borrarReceta(resp.clave);if(KL.MP.tipovista=='mes')
{KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaMes,false);}}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
KL.MP.agreganodeid=undefined;KL.MP.agregadia=undefined;KL.MP.agregatipo=undefined;KL.MP.agregareceta=undefined;function agregaRecetaDSM(dia,tipo)
{KL.MP.agregadia=dia;KL.MP.agregatipo=tipo;KL.MP.fec_seleccionada=dia;KL.popup.show("mp-toolbox-agregar");mp_agregashow('mp-busqueda-box');WA.toDOM('mp-bbox-clasif').style.left='0px';WA.toDOM('mp-bbox-result').style.left='300px';}
function mp_agregashow(id)
{WA.toDOM('mp-busqueda-box').style.display='none';WA.toDOM('mp-comida-box').style.display='none';WA.toDOM(id).style.display='block';}
var paginaVer=1;var recetasCargadas=false;var claveClasificacion=0;function mpGetRecetasClasificacion(clave)
{paginaVer=1;claveClasificacion=0;recetasCargadas=false;var request=WA.Managers.ajax.createRequest('/listeners/getbuscar','POST','tipo=r',mpRecetasClasificacionRespuesta,false);request.addParameter('f',2);request.addParameter('cats',clave);request.addParameter('ordena','masrecomendado');request.addParameter('pagina',paginaVer);request.addParameter('vista','json');request.send();claveClasificacion=clave;paginaVer++;}
function mpRecetasClasificacionRespuesta(request)
{var data=JSON.parse(request.responseText);mp_getbuscarInfoTmp=data;if(!data)
return;if(recetasCargadas)
{if(WA.toDOM('resultado_vermas'))
{var aux=WA.toDOM('resultado_vermas');WA.toDOM('mp-bbox-result').removeChild(aux);}
for(var x in data.result)
{var node=KL.MP.fabricarecetaagrega(data.result[x]);WA.toDOM('mp-bbox-result').appendChild(node);}
WA.toDOM('mp-bbox-clasif').style.left='-300px';WA.toDOM('mp-bbox-result').style.left='0';var nodo2=WA.createDomNode('div','resultado_vermas');nodo2.innerHTML='<div onclick="verMasRecetas();" ><span>'+WA.i18n.getMessage("txtplaneador6")+'</span></div>';WA.toDOM('mp-bbox-result').appendChild(nodo2);}
else
{WA.toDOM('mp-bbox-result').innerHTML='<div id="ContenedorRegresar" class="ContenedorRegresar" onclick="mpRegresarClasificaciones();"><div class="flechaRegresar"><img src="'+KL.cdndomain+'/img/static/k4-planner_regresar.png"></div><div class="titulo-regresar"><label>'+WA.i18n.getMessage("txtplaneador7")+'</label></div></div>';for(var x in data.result)
{var node=KL.MP.fabricarecetaagrega(data.result[x]);WA.toDOM('mp-bbox-result').appendChild(node);}
WA.toDOM('mp-bbox-clasif').style.left='-300px';WA.toDOM('mp-bbox-result').style.left='0';var nodo1=WA.createDomNode('div','resultado_vermas');nodo1.innerHTML='<div onclick="verMasRecetas();" ><span>'+WA.i18n.getMessage("txtplaneador6")+'</span></div>';WA.toDOM('mp-bbox-result').appendChild(nodo1);recetasCargadas=true;}}
function verMasRecetas()
{recetasCargadas=true;var request=WA.Managers.ajax.createRequest('/listeners/getbuscar','POST','tipo=r',mpRecetasClasificacionRespuesta,false);request.addParameter('f',2);request.addParameter('cats',claveClasificacion);request.addParameter('ordena','masrecomendado');request.addParameter('pagina',paginaVer);request.addParameter('vista','json');request.send();paginaVer++;}
function mpRegresarClasificaciones()
{WA.toDOM('mp-bbox-clasif').style.left='0px';WA.toDOM('mp-bbox-result').style.left='300px';}
function mpComidaTipo(claveReceta)
{KL.MP.agregareceta=claveReceta;mp_agregashow('mp-comida-box');if(KL.MP.armaMenu)
WA.toDOM("mp-cbox-comida-5").style.display='none';if(KL.MP.agregatipo)
mpSetComidaTipo(KL.MP.agregatipo);}
function mpSetComidaTipo(tipo)
{KL.popup.hide();if(KL.MP.armaMenu==0)
{if(KL.MP.tipovista=='semana')
{KL.MP.agregadia=KL.MP.fec_ini+KL.MP.agregadia-1;}
WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=agregarReceta&clavereceta='+KL.MP.agregareceta+'&dia='+KL.MP.agregadia+'&tipo='+tipo,mpRespuestaAgregaReceta,true);}
else
{for(var x in mp_getbuscarInfoTmp.result)
{var clave=mp_getbuscarInfoTmp.result[x].clave;var nombre=mp_getbuscarInfoTmp.result[x].nombre;var imagen=mp_getbuscarInfoTmp.result[x].imagen;var ligaimagen=mp_getbuscarInfoTmp.result[x].ligaimagen;if(clave==KL.MP.agregareceta)
{var nodo=WA.createDomNode('div','mp_cm|'+tipo+'|'+KL.MP.agregadia+'|'+clave,'mp_cm');var receta='  <div id=img_'+clave+' class="mp_cm_foto">'
+'  <img src="'+ligaimagen+'">'
+'  </div>'
+'  <div class="mp_cm_nombre">'
+nombre
+'  </div>'
+'  <div class="mp_cm_quitar" onclick="mp_quitar_rec(\'mp_cm|'+tipo+'|'+KL.MP.agregadia+'|'+clave+'\', '+KL.MP.agregadia+')">'
+'  </div>'
+'  <div style="clear:both;"></div>';nodo.innerHTML=receta;WA.toDOM('mp_tipo_'+tipo+'_'+KL.MP.agregadia).appendChild(nodo);nodoReceta=WA.toDOM("mp_tipo_"+tipo+'_'+KL.MP.agregadia);if(nodoReceta.innerHTML)
WA.toDOM("mp_tipo_icn_"+tipo+'_'+KL.MP.agregadia).style.display='block';var nodo2=WA.toDOM('img_'+clave);nodo2.setAttribute("onclick","mp_resumenReceta('"+clave+"')");}}}}
function mpRespuestaAgregaReceta(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{if(KL.MP.tipovista=='dia')
KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaDia,true);else if(KL.MP.tipovista=='semana')
KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaSemana,true);else if(KL.MP.tipovista=='mes')
KL.MP.loader.solicitarinformacion(KL.MP.fec_ini,KL.MP.fec_fin,rellenaMes,true);}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function mpBuscaPalabra()
{var texto=WA.toDOM('mp-bboxb-input').value;var request=WA.Managers.ajax.createRequest('/listeners/getbuscar','POST','tipo=r',mpRecetasClasificacionRespuesta,false);request.addParameter('f',2);request.addParameter('ordena','masrecomendado');request.addParameter('q',WA.UTF8.encode(texto));request.addParameter('pagina',1);request.addParameter('vista','json');request.send();}
function agregarIngrediente()
{var request=WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=agregaringrediente',recibiringrediente,false);}
var mp_clavereceta=null;var mp_dia=null;var diasSemana=new Array(WA.i18n.getMessage("loaderdiamin1"),WA.i18n.getMessage("loaderdiamin2"),WA.i18n.getMessage("loaderdiamin3"),WA.i18n.getMessage("loaderdiamin4"),WA.i18n.getMessage("loaderdiamin5"),WA.i18n.getMessage("loaderdiamin6"),WA.i18n.getMessage("loaderdiamin7"));var mesescortos=new Array("01","02","03","04","05","06","07","08","09","10","11","12");var diasSemanaCompleto=new Array(WA.i18n.getMessage("loaderdia1"),WA.i18n.getMessage("loaderdia2"),WA.i18n.getMessage("loaderdia3"),WA.i18n.getMessage("loaderdia4"),WA.i18n.getMessage("loaderdia5"),WA.i18n.getMessage("loaderdia6"),WA.i18n.getMessage("loaderdia7"));var meses=new Array("",WA.i18n.getMessage("loadermes1"),WA.i18n.getMessage("loadermes2"),WA.i18n.getMessage("loadermes3"),WA.i18n.getMessage("loadermes4"),WA.i18n.getMessage("loadermes5"),WA.i18n.getMessage("loadermes6"),WA.i18n.getMessage("loadermes7"),WA.i18n.getMessage("loadermes8"),WA.i18n.getMessage("loadermes9"),WA.i18n.getMessage("loadermes10"),WA.i18n.getMessage("loadermes11"),WA.i18n.getMessage("loadermes12"));var diascortos=new Array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");var mp_widthday=70;if(globalwidth>767)
var mp_widthday=90;var mp_dia_hoy=new Date();var id_mp_dia_hoy=mp_dia_hoy.getFullYear()+'-'+mesescortos[mp_dia_hoy.getMonth()]+'-'+diascortos[mp_dia_hoy.getDate()];var mp_posicion_actual=0;var mp_posiciondia_actual=0;var mp_colecciondias={};var min=null;var max=null;var calendario=false;var bloqueDisplay='dia';var flagToolBox='cerrado';var nodoFlag=undefined;var mpTempClaveReceta=null;var mpTempDiaInsert=null;var tipoCalendarioVista=undefined;var mp_rango_menor=1000000;var mp_rango_mayor=-1000000;var mp_rango_offsetDia=1000000;var diaToken=undefined;var semanaToken=undefined;var mesToken=undefined;var tipoRellenoDia=undefined;var nodoToolBoxActivo=undefined;var diaToolBoxActivo=undefined;var tipoToolBoxActivo='dia';var mp_MesInfoObj=new Array();var mp_getbuscarInfoTmp=new Array();var redetaDataTmpNode=new Array();var mp_tipo_icono=new Array("",WA.i18n.getMessage("txtplaneadortipo1"),WA.i18n.getMessage("txtplaneadortipo2"),WA.i18n.getMessage("txtplaneadortipo3"),WA.i18n.getMessage("txtplaneadortipo4"),WA.i18n.getMessage("txtplaneadortipo5"));var mp_dotsTipo=new Array('','<div class="mp-pelota-comidacolor mp-pelota-desayuno"></div>','<div class="mp-pelota-comidacolor mp-pelota-comida"></div>','<div class="mp-pelota-comidacolor mp-pelota-cena"></div>','<div class="mp-pelota-comidacolor mp-pelota-snack"></div>','<div class="mp-pelota-comidacolor mp-pelota-ninguno"></div>');var mp_MesesArray=new Array(WA.i18n.getMessage("loadermes1"),WA.i18n.getMessage("loadermes2"),WA.i18n.getMessage("loadermes3"),WA.i18n.getMessage("loadermes4"),WA.i18n.getMessage("loadermes5"),WA.i18n.getMessage("loadermes6"),WA.i18n.getMessage("loadermes7"),WA.i18n.getMessage("loadermes8"),WA.i18n.getMessage("loadermes9"),WA.i18n.getMessage("loadermes10"),WA.i18n.getMessage("loadermes11"),WA.i18n.getMessage("loadermes12"));function mp_offset2date(offset)
{return new Date(new Date().getTime()+(24*3600000)*offset);}
function mp_offset2string(offset)
{var fecha=mp_offset2date(offset);return fecha.getFullYear()+'-'+mesescortos[fecha.getMonth()]+'-'+diascortos[fecha.getDate()];}
function mp_abrirbarra(clavereceta,nohelp,hook)
{if(!cheflogged)
return switchpulldown(null,'menuplanner');mp_clavereceta=clavereceta;mp_cerrarContTipo();if(!nohelp)
mp_abrirAyuda();KL.popup.show("mp_herramientas-flotantes",false,hook);WA.toDOM("mp_herramientas-flotantes").style.top='0px';mp_creaTira(0);mp_verificaprimerdia();}
function mp_cerrarbarra()
{KL.popup.hide();mp_clavereceta=null;}
function mp_tipos(e)
{if(!mp_clavereceta)
return;mp_cerrarAyuda();if(mp_dia)
{if(id_mp_dia_hoy==mp_dia)
WA.toDOM('mp_dia|'+mp_dia).className="mp_dia mp_hoy";else
WA.toDOM('mp_dia|'+mp_dia).className="mp_dia";}
mp_dia=this.fechadia;var mi_nodo=(WA.browser.getNodeNodeLeft(WA.toDOM('mp_clipping'),WA.toDOM('mp_herramientas-flotantes'))-100);var miposicion=parseInt(this.style.left,10)+mp_posicion_actual+mi_nodo;if(miposicion<1)
WA.toDOM("mp_tipo_contenedor").style.left="0px";else
WA.toDOM("mp_tipo_contenedor").style.left=miposicion+"px";WA.toDOM("mp_tipo_contenedor").style.display="block";if(!WA.toDOM('mp_dia|'+mp_dia).style.backgroundImage)
WA.toDOM('mp_dia|'+mp_dia).className="mp_dia mp_activo";}
function mp_cerrarContTipo(event)
{WA.toDOM("mp_tipo_contenedor").style.display="none";}
function mp_cerrarTipo(event)
{WA.toDOM("mp_tipo_contenedor").style.display="none";if(mp_dia)
{if(id_mp_dia_hoy==mp_dia)
WA.toDOM('mp_dia|'+mp_dia).className="mp_dia mp_hoy";else
WA.toDOM('mp_dia|'+mp_dia).className="mp_dia";}
if(WA.toDOM("mp_resumen_receta"))
WA.toDOM("mp_resumen_receta").style.display="none";}
function mp_cerrarAyuda()
{WA.toDOM("mp_ayuda").style.display="none";}
function mp_abrirAyuda()
{WA.toDOM("mp_ayuda").style.display="block";}
function mp_agregarReceta(tipo,clavereceta,diaoffset)
{var clave_receta=null;var dia_offset=0;if(clavereceta)
clave_receta=clavereceta;else if(mp_clavereceta)
clave_receta=mp_clavereceta;else
return;if(WA.toDOM('mp_dia|'+mp_dia))
dia_offset=WA.toDOM('mp_dia|'+mp_dia).offsetdia;else if(diaoffset||diaoffset==0)
dia_offset=diaoffset;else
return;WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=agregarReceta&clavereceta='+clave_receta+'&dia='+dia_offset+'&tipo='+tipo,mp_RespuestaagregarReceta,true);}
function mp_RespuestaagregarReceta(request)
{var verifica_puntos=0;var resp=JSON.parse(request.responseText);mp_cerrarbarra();if(resp.estatus=='OK')
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));confirma(WA.i18n.getMessage("txtplaneador8"),WA.i18n.getMessage("txtplaneador9"),WA.i18n.getMessage("txtplaneador10"),confirmaCalendario);if(resp.imagen)
{if(globalwidth>767)
{if(WA.toDOM('mp_dia|'+mp_dia))
WA.toDOM('mp_dia|'+mp_dia).style.backgroundImage="url("+KL.cdndomain+"/recetaimagen/"+resp.receta+"/thumb90-"+resp.imagen+")";if(WA.toDOM("fondo_"+mp_dia))
WA.toDOM("fondo_"+mp_dia).style.opacity=".4";if(WA.toDOM('mp_dia|'+mp_dia))
WA.toDOM('mp_dia|'+mp_dia).style.color="#fff";}
else
{if(WA.toDOM("mp-mob-md-"+mp_dia))
{var div_cont=WA.toDOM("mp-mob-md-"+mp_dia);for(var u=0;u<=div_cont.childNodes.length;u++)
{var nodo_contenido=div_cont.childNodes[u];if(nodo_contenido)
{if(nodo_contenido.className=='mp-pelota-comidacolor mp-pelota-'+mp_tipo_icono[resp.tipo])
verifica_puntos++;}}
if(verifica_puntos==0)
{WA.toDOM("mp-mob-md-"+mp_dia).innerHTML+=mp_dotsTipo[resp.tipo];}}}}
else
{if(globalwidth>767)
{if(WA.toDOM('mp_dia|'+mp_dia))
WA.toDOM('mp_dia|'+mp_dia).style.backgroundImage="url('"+KL.cdndomain+"/img/static/logo-o-90.png')";if(WA.toDOM("fondo_"+mp_dia))
WA.toDOM("fondo_"+mp_dia).style.opacity=".4";if(WA.toDOM('mp_dia|'+mp_dia))
WA.toDOM('mp_dia|'+mp_dia).style.color="#fff";}}
if(calendario)
{var attTemp=WA.toDOM('mp-bloque-dia').getAttribute("view");if(attTemp=='mes')
addTmpNode(resp.receta,resp.clave);if(bloqueDisplay=='dia')
mpFillMesSemanaDiaCompleto('dia');if(bloqueDisplay=='semana')
mpFillMesSemanaDiaCompleto('semana');if(bloqueDisplay=='mes'&&tipoToolBoxActivo=='mes')
mpFillMesSemanaDiaCompleto('mes');}}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));notifica(resp.mensaje);}}
function confirmaCalendario(id)
{if(id==1)
window.location='/mi-cuenta/planeador-de-menu';}
function getconfirma(id)
{if(id==1)
window.location='/mi-cuenta/planeador-de-menu';if(id==2)
window.location='/mi-cuenta/planeador-de-menu/arma-tu-menu';}
function mp_moverReceta()
{var clave=WA.toDOM("clave").value;var dia=WA.toDOM("dia").value;var tipo=WA.toDOM("tipo").value;var antesde=WA.toDOM("antesde").value;var err="";if(clavereceta=="")
err=WA.i18n.getMessage("txtplaneador11");if(dia=="")
err+=WA.i18n.getMessage("txtplaneador12");if(tipo=="")
err+=WA.i18n.getMessage("txtplaneador13");if(err)
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(err);}
else
WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=moverReceta&clave='+clave+'&dia='+dia+'&tipo='+tipo+'&antesde='+antesde,mp_RespuestamoverReceta,true);}
function mp_RespuestamoverReceta(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function mp_eliminarReceta()
{var clave=WA.toDOM("clave").value;if(clavereceta)
WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=eliminarReceta&clave='+clave,mp_RespuestaeliminarReceta,true);else
return;}
function mp_RespuestaeliminarReceta(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function mp_menuplanner()
{var fec_ini_mp=WA.toDOM("fec_ini").value;var fec_fin_mp=WA.toDOM("fec_fin").value;WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','fec_ini='+fec_ini_mp+'&fec_fin='+fec_fin_mp,mp_Respuestamenuplanner,true);}
function mp_Respuestamenuplanner(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function mp_moverizquierda()
{var cantidad=mp_calculacantidadcasillas();var diaantes=mp_offset2date(mp_posiciondia_actual).getDate();mp_posiciondia_actual-=cantidad[1];var diadespues=mp_offset2date(mp_posiciondia_actual).getDate();if(diadespues>diaantes)
mp_posiciondia_actual++;mp_posicion_actual+=cantidad[1]*mp_widthday;WA.toDOM("mp_tira_imagen").style.left=mp_posicion_actual+'px';mp_creaTira(mp_posiciondia_actual);mp_verificaprimerdia();mp_cerrarContTipo();}
function mp_moverderecha()
{var cantidad=mp_calculacantidadcasillas();var diaantes=mp_offset2date(mp_posiciondia_actual).getDate();mp_posiciondia_actual+=cantidad[1];var diadespues=mp_offset2date(mp_posiciondia_actual).getDate();if(diadespues<diaantes&&diadespues!=1)
mp_posiciondia_actual--;mp_posicion_actual-=cantidad[1]*mp_widthday;WA.toDOM("mp_tira_imagen").style.left=mp_posicion_actual+'px';mp_creaTira(mp_posiciondia_actual);mp_verificaprimerdia();mp_cerrarContTipo();}
function mp_creaTira(offsetdias)
{var cantidad=mp_calculacantidadcasillas();for(var df=offsetdias;df<=offsetdias+cantidad[0];df++)
{if(mp_colecciondias[df])
continue;var nodo=creaDia(df);mp_colecciondias[df]=nodo;WA.toDOM('mp_tira_imagen').appendChild(nodo);}
var intervalo=null;if(min==null&&max==null)
{min=offsetdias;max=offsetdias+cantidad[0];intervalo=[min,max];}
else if(offsetdias<min)
{intervalo=[offsetdias,min-1];min=offsetdias;}
else if(offsetdias+cantidad[0]>max)
{intervalo=[max+1,offsetdias+cantidad[0]];max=offsetdias+cantidad[0];}
if(intervalo)
{WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','fec_ini='+intervalo[0]+'&fec_fin='+intervalo[1],respuestaGetDias,true);}}
function respuestaGetDias(request)
{var resp=JSON.parse(request.responseText);var calendario=false;for(var prop in resp.data)
{var calendario=true;var objetoDia=resp.data[prop];var arrayTmp=new Array();for(var pro in objetoDia)
{if(globalwidth<767)
{if(!arrayTmp[mp_dotsTipo[objetoDia[pro].tipo]])
{WA.toDOM("mp-mob-md-"+objetoDia[pro].dia).innerHTML+=mp_dotsTipo[objetoDia[pro].tipo];arrayTmp[mp_dotsTipo[objetoDia[pro].tipo]]=true;}}
else
{if(objetoDia[pro].dia)
{WA.toDOM('mp_dia|'+objetoDia[pro].dia).style.backgroundImage="url("+KL.cdndomain+"/recetaimagen/"+objetoDia[pro].receta+"/thumb90-"+objetoDia[pro].imagen+")";WA.toDOM('mp_dia|'+objetoDia[pro].dia).style.color="#fff";WA.toDOM("fondo_"+objetoDia[pro].dia).style.opacity=".4";break;}
else
{WA.toDOM('mp_dia|'+objetoDia[pro].dia).style.backgroundImage="url('"+KL.cdndomain+"/img/static/logo-o-90.png')";WA.toDOM("fondo_"+objetoDia[pro].dia).style.opacity=".4";}}}}}
function mp_verificaprimerdia()
{var id=mp_colecciondias[mp_posiciondia_actual].id;WA.toDOM("mp_mes_fijo").innerHTML=meses[parseInt(id.substr(12,2),10)];if(parseInt(mp_colecciondias[mp_posiciondia_actual].style.left,10)!=-mp_posicion_actual)
{mp_posicion_actual-=mp_widthday;WA.toDOM("mp_tira_imagen").style.left=mp_posicion_actual+'px';}}
function creaDia(dia)
{var dias=mp_offset2date(dia);var hoy='';var etiquetaDia=diasSemana[dias.getDay()];if(dia==0)
{hoy=" mp_hoy";etiquetaDia='Hoy';}
var id=mp_offset2string(dia);var tira_dias=null;if(dias.getDate()==1)
{var nodo=WA.createDomNode('div','mes_'+id,'mp_dia mp_mes');var nom_mes=(dias.getMonth()+1);nodo.style.left=mp_calculaposiciondia(dia,-mp_widthday);nodo.innerHTML=meses[nom_mes];WA.toDOM('mp_tira_imagen').appendChild(nodo);tira_dias='<div class="mp_dia mp_mes">'+meses[nom_mes]+'</div>';}
else
{tira_dias='';}
var nodo=WA.createDomNode('div','mp_dia|'+id,'mp_dia'+hoy);nodo.style.left=mp_calculaposiciondia(dia);nodo.onclick=mp_tipos;nodo.innerHTML="<div class='mp_fondo_dia' id='fondo_"+id+"'></div>"
+"<div class='mp_ley_dia'>"+etiquetaDia+"<br />"
+"<div class='mp_num_dia'>"+dias.getDate()+"</div>"
+"<div id='mp-mob-md-"+id+"' class='mp-md-dots-barra'>"
+"</div>";nodo.offsetdia=dia;nodo.fechadia=id;return nodo;}
function mp_calculacantidadcasillas()
{return[Math.ceil(WA.browser.getNodeWidth(WA.toDOM('mp_clipping'))/mp_widthday),Math.floor(WA.browser.getNodeWidth(WA.toDOM('mp_clipping'))/mp_widthday)];}
function mp_calculaposiciondia(offsetdia,extraoffset)
{var today=new Date();var offsetday=mp_offset2date(offsetdia);var yeartoday=today.getFullYear();var yearoffsetday=offsetday.getFullYear();var monthtoday=today.getMonth();var monthoffsetday=offsetday.getMonth();var months=(yearoffsetday-yeartoday)*12+(monthoffsetday-monthtoday);return(mp_widthday*(offsetdia+months)+(extraoffset?extraoffset:0))+'px';}
function mp_movergrupo(p1,p2,p3,p4,p5)
{if(p4.substr(0,15)=='mp-cont-mes-dia')
{if(p1=='enterzone')
WA.toDOM(p4).style.border='3px solid red';if(p1=='exitzone')
WA.toDOM(p4).style.border='';}
else if(p4.substr(0,20)=='mp-cont-dia-completo')
{if(p1=='enterzone')
WA.toDOM(p4).style.border='3px solid red';if(p1=='exitzone')
WA.toDOM(p4).style.border='';}
else if(p4.substr(0,18)=='mp-cont-semana-dia')
{if(p1=='enterzone')
WA.toDOM(p4).style.border='3px solid red';if(p1=='exitzone')
WA.toDOM(p4).style.border='';}
else if(p4.substr(0,11)=='mp-cont-dia')
{if(p1=='enterzone')
WA.toDOM(p4).style.border='3px solid red';if(p1=='exitzone')
WA.toDOM(p4).style.border='';}
else if(p4.substr(0,6)=='mp_dia')
{if(p1=='enterzone')
WA.toDOM(p4).className='mp_dia drag';if(p1=='exitzone')
WA.toDOM(p4).className='mp_dia';}}
function mp_moverzona(p1,p2,p3,p4,p5)
{return true;}
function mp_moverreceta(p1,p2,p3,p4,p5)
{if(p1=='drop'&&p4)
{var receta=p3.split("|");var container=p4.split("|");if(container[0]=="mp_dia")
{mp_clavereceta=receta[1];mp_tipos.call(WA.toDOM(p4));return;}
alert(WA.i18n.getMessage("txtplaneador14")+' id='+receta+' '+WA.i18n.getMessage("txtplaneador15")+' id='+container);}
return true;}
function mp_iniciamenu()
{l_selected=WA.toDOM("filtro_menus");mp_buscamenu(l_selected);}
function mp_buscamenu(nodo)
{var val=nodo.value;var nl=WA.toDOM('div_cont_gral_listarecetasmenu').childNodes;var arr=[];for(var i=0,n;n=nl[i];++i)arr.push(n);arr.forEach(function(node)
{if(node.className!='mp_listareceta')
return;WA.toDOM('div_cont_gral_listarecetasmenu').removeChild(node);});WA.toDOM('div_cont_gral_listarecetasmenu').innerHTML=WA.toDOM('div_cont_gral_listarecetasmenu').innerHTML='<div id="engrane_recetas"><img src="'+KL.cdndomain+'/img/static/carga.gif"></div>';WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','orden=recomendadas&menu='+val,mp_respuestabuscamenu,true);}
function mp_respuestabuscamenu(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{WA.toDOM('div_cont_gral_listarecetasmenu').innerHTML='';for(var i=0,l=resp.data.length;i<l;i++)
{var nodo=WA.createDomNode('div','mp_listareceta|'+resp.data[i].clave,'mp_listareceta');nodo.innerHTML=resp.data[i].html;WA.toDOM('div_cont_gral_listarecetasmenu').appendChild(nodo);nodo.setAttribute("onclick","mp_resumenReceta('"+resp.data[i].clave+"')");}}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}
cargaImagenes('postload');}
function getmenudata(request)
{menuInfo=WA.JSON.decode(request.responseText);WA.toDOM('menu-data-loading').style.display='none';WA.toDOM('menu-data-opciones').style.display='block';fillMenuInfo(tempID);}
function mp_seleccionacolumna(e,id)
{var valcolumna=true;for(var i=1;i<5;i++)
valcolumna&=WA.toDOM('chec-'+i+'-'+id).checked;for(var i=1;i<5;i++)
mp_seleccionacelda(null,i,id,valcolumna);WA.browser.cancelEvent(e);}
function mp_seleccionalinea(e,id)
{var vallinea=true;for(var i=0;i<7;i++)
vallinea&=WA.toDOM('chec-'+id+'-'+i).checked;for(var i=0;i<7;i++)
mp_seleccionacelda(null,id,i,vallinea);WA.browser.cancelEvent(e);}
function mp_seleccionacelda(e,id,iddia,forzar)
{if(forzar===undefined)
var val=WA.toDOM('chec-'+id+'-'+iddia).checked;else
val=forzar;if(val)
{WA.toDOM('chec-'+id+'-'+iddia).checked=false;WA.toDOM('mp-chec-'+id+'-'+iddia).className='cel_checkbox off';}
else
{WA.toDOM('chec-'+id+'-'+iddia).checked=true;WA.toDOM('mp-chec-'+id+'-'+iddia).className='cel_checkbox on';}
WA.browser.cancelEvent(e);}
mpv_tiempo=0;function mp_tiempo(tipo)
{mpv_tiempo=tipo;var nodo=WA.toDOM('barratiempo_indice');if(!nodo)
return;nodo.className=(tipo==0?'div_barratiempo_indice avg0':(tipo==1?'div_barratiempo_indice avg50':'div_barratiempo_indice avg100'));}
function mp_resumenReceta(clavereceta)
{mp_clavereceta=clavereceta;WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','orden=recetaresumen&clavereceta='+clavereceta,mp_resumenRecetaRespuesta,true);if(WA.toDOM("mp_resumen_receta")){WA.toDOM("icon_cierra_popup_pl_menu").style.display='block';WA.toDOM("mp_resumen_receta").style.display='block';WA.toDOM("mp_herramientas-flotantes").style.top='0px';}
mp_abrirbarra(mp_clavereceta,true,mp_restablecerbarra);}
function mp_resumenRecetaRespuesta(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{if(WA.toDOM('mp_resumen_receta'))
WA.toDOM('mp_resumen_receta').innerHTML=resp.data+"<div style='clear: both;'></div>";cargaImagenes('postload');}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function mp_restablecerbarra()
{mp_clavereceta=null;mp_cerrarContTipo();WA.toDOM("mp_resumen_receta").style.display='none';WA.toDOM("icon_cierra_popup_pl_menu").style.display='none';WA.toDOM('mp_contenedor-herramientas-flotantes').appendChild(WA.toDOM("mp_herramientas-flotantes"));}
function BarraSemana()
{var dias=null;var etiquetaDia=null;for(var r=1;r<8;r++)
{dias=mp_offset2date(r);etiquetaDia=diasSemanaCompleto[dias.getDay()];WA.toDOM("mp_s_dia_"+r).innerHTML=etiquetaDia+'  '+dias.getDate();}}
var json_semana=null;function mp_limpiaContenedorTipo()
{for(var x=0;x<7;x++)
{for(var y=1;y<5;y++)
{if(WA.toDOM("mp_tipo_"+y+'_'+x))
{WA.toDOM("mp_tipo_"+y+'_'+x).innerHTML='';WA.toDOM("mp_tipo_icn_"+y+'_'+x).style.display='none';WA.toDOM("mp_tipo_divisor_"+y+'_'+x).style.display='none';}}}}
var mp_cr_recetas=null;function mpbuscaIngrediente(id)
{setTimeout(function(){mpverificacampobusqueda(id);},0);}
var timer=null;function mpverificacampobusqueda(id)
{if(timer)
{clearTimeout(timer);timer=null;}
var numCaracteres=0;numCaracteres=WA.toDOM('gustan_'+id).value.length;if(numCaracteres>=3)
timer=setTimeout(function(){mpejecutaBusqueda(id);},300);else
WA.toDOM("listapref_gusta"+id).style.display="none";}
function mpejecutaBusqueda(id)
{var busqueda=WA.toDOM('gustan_'+id).value;var request=WA.Managers.ajax.createRequest('/listeners/getbuscaringrediente','POST','orden=busqueda&id='+id,recibiringrediente,false);request.addParameter('ingredienteBuscado',WA.UTF8.encode(busqueda));request.send();}
function recibiringrediente(request)
{var resp=WA.JSON.decode(request.responseText);if(resp.estatus=='OK')
{WA.toDOM("listapref_gusta"+resp.id).style.display="block";WA.toDOM("listapref_gusta"+resp.id).innerHTML='';var num=0;for(var i in resp.respuesta)
{WA.toDOM("listapref_gusta"+resp.id).innerHTML+='<div class="listaprev_gusta" onclick="seleccionarIngrediente(\''+resp.respuesta[i]+'\', \''+resp.id+'\');">'+resp.respuesta[i]+'</div>';num++;if(num==10)
break;}
if(num==0)
WA.toDOM("listapref_gusta"+resp.id).innerHTML+='<p> '+WA.i18n.getMessage("txtplaneador16")+' </p>';}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(resp.mensaje);}}
function seleccionarIngrediente(Ingrediente,id)
{WA.toDOM("listapref_gusta"+id).style.display="none";agregaIngrediente(id,Ingrediente);WA.toDOM('gustan_'+id).value='';}
var numIngredientes=0;var ingredientesSI={};var ingredientesNO={};function agregaIngrediente(id,data)
{if(data)
var ingredienteSeleccionado=data;else
var ingredienteSeleccionado=WA.toDOM('gustan_'+id).value;ingredienteSeleccionado.trim();if(ingredienteSeleccionado)
{if(validaIngrediente(ingredienteSeleccionado,id))
{WA.toDOM("seleccionaIngredientesGustan"+id).innerHTML+='<div id="divIngrediente_'+numIngredientes+'" + class="divIngrediente"></div>';WA.toDOM("divIngrediente_"+numIngredientes).innerHTML+='<div class="listaIngredientesGustanDerecha" onclick="eliminarIngrediente(\''+numIngredientes+'\', \''+id+'\');"></div>';WA.toDOM("divIngrediente_"+numIngredientes).innerHTML+='<div id="ingediente_'+numIngredientes+'" + class="listaIngredientesGustanIzquierda">'+ingredienteSeleccionado+'</div>';WA.toDOM("divIngrediente_"+numIngredientes).innerHTML+='<div style="clear:both"></div>';if(id=='si')
ingredientesSI[numIngredientes]=ingredienteSeleccionado;else
ingredientesNO[numIngredientes]=ingredienteSeleccionado;numIngredientes++;WA.toDOM("listapref_gusta"+id).style.display="none";WA.toDOM('gustan_'+id).value='';}}
else
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(WA.i18n.getMessage("txtplaneador17"));}}
function eliminarIngrediente(ingrediente_id,id)
{var nodo=WA.toDOM("divIngrediente_"+ingrediente_id);WA.toDOM("seleccionaIngredientesGustan"+id).removeChild(nodo);if(id=='si')
delete ingredientesSI[ingrediente_id];else
delete ingredientesNO[ingrediente_id];}
function validaIngrediente(ingrediente,id)
{if(numIngredientes==0)
return true;if(id=='si')
{for(var i=0;i<=numIngredientes;i++)
{if(ingredientesSI[i]==ingrediente)
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(WA.i18n.getMessage("txtplaneador18"));return false;}}
return true;}
else
{for(var i=0;i<=numIngredientes;i++)
{if(ingredientesNO[i]==ingrediente)
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(WA.i18n.getMessage("txtplaneador18"));return false;}}
return true;}}
function mp_armaTuMenu()
{var mp_tira_semana={dia:{},nd:{}};var error_semana=0;if(KL.MP.seleccion==undefined)
{for(var x=0;x<7;x++)
{mp_tira_semana.dia[x]={};mp_tira_semana.nd[x]={};for(var y=1;y<5;y++)
{if(WA.toDOM("chec-"+y+"-"+x).checked==true&&WA.toDOM("chec-"+y+"-"+x))
{mp_tira_semana.nd[x]=WA.toDOM("chec-"+y+"-"+x).value;mp_tira_semana.dia[x][y]=true;error_semana++;}}}
KL.MP.seleccion=mp_tira_semana;if(error_semana==0)
{fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));alerta(WA.i18n.getMessage("txtplaneador19"));mp_limpiaContenedorTipo();return;}
KL.MP.dieta.Soya=WA.toDOM("Soya").checked;KL.MP.dieta.Mariscos=WA.toDOM("Mariscos").checked;KL.MP.dieta.gluten=WA.toDOM("gluten").checked;KL.MP.dieta.Nueces=WA.toDOM("Nueces").checked;}
else
{mp_tira_semana=KL.MP.seleccion;}
json_semana=WA.JSON.encode(mp_tira_semana);var json_dieta=WA.JSON.encode(KL.MP.dieta);var json_SI=WA.JSON.encode(ingredientesSI);var json_NO=WA.JSON.encode(ingredientesNO);nodo1=WA.createDomNode('div','engrane_recetas','');var engrane='<div id="engrane_recetas" ><img src="'+KL.cdndomain+'/img/static/carga.gif"><label style="color: #8DC540; margin-left: 28px;">'+WA.i18n.getMessage("txtplaneador20")+'</label></div>';nodo1.innerHTML=engrane;WA.toDOM("mp_filtros").style.display="none";window.scrollTo(0,0);WA.Managers.ajax.createRequest('/listeners/getmenuplanner','POST','orden=crearmenu&semana='+json_semana+'&tiempo='+mpv_tiempo+'&dieta='+json_dieta+'&ingredientesSI='+json_SI+'&ingredientesNO='+json_NO,mp_armaTuMenuRespuesta,true);}
function mp_armaTuMenuRespuesta(request)
{mp_cr_recetas=request.responseText;var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{mp_limpiaContenedorTipo();for(var v_dia in resp.armado)
{var v_recetas=resp.armado[v_dia];for(var v_rec in v_recetas)
{WA.toDOM("mp_tipo_icn_"+v_recetas[v_rec].tipo+'_'+v_dia).style.display='block';WA.toDOM("mp_con_agregarmenu_"+v_recetas[v_rec].dia).style.display='block';if(v_recetas[v_rec].imagen)
var imagenReceta=KL.cdndomain+'/recetaimagen/'+v_recetas[v_rec].clavereceta+'/thumb90-'+v_recetas[v_rec].imagen;else
var imagenReceta=KL.cdndomain+'/img/static/logo-o-90.png';var nodo=WA.createDomNode('div','mp_cm|'+v_recetas[v_rec].tipo+'|'+v_dia+'|'+v_recetas[v_rec].clavereceta,'mp_cm');var receta='  <div id=img_'+v_recetas[v_rec].clavereceta+' class="mp_cm_foto">'
+'  <img src="'+imagenReceta+'">'
+'  </div>'
+'  <div class="mp_cm_nombre">'
+v_recetas[v_rec].nombrereceta
+'  </div>'
+'  <div class="mp_cm_quitar" onclick="mp_quitar_rec(\'mp_cm|'+v_recetas[v_rec].tipo+'|'+v_dia+'|'+v_recetas[v_rec].clavereceta+'\', '+v_recetas[v_rec].dia+')">'
+'  </div>'
+'  <div style="clear:both;"></div>';nodo.innerHTML=receta;WA.toDOM("mp_tipo_"+v_recetas[v_rec].tipo+"_"+v_dia).appendChild(nodo);var nodo2=WA.toDOM('img_'+v_recetas[v_rec].clavereceta);nodo2.setAttribute("onclick","mp_resumenReceta('"+v_recetas[v_rec].clavereceta+"')");}}
WA.toDOM("mp_filtros").style.display="none";WA.toDOM("div_btn_regresar").style.display="block";WA.toDOM("div_btn_agregamenu").style.display="block";WA.toDOM("mp_resultados").style.display="block";KL.MP.armaMenu=1;window.scrollTo(0,0);}}
function regresar()
{KL.MP.seleccion=undefined;WA.toDOM("mp_resultados").style.display="none";WA.toDOM("mp_filtros").style.display="block";WA.toDOM("div_btn_regresar").style.display="none";WA.toDOM("div_btn_agregamenu").style.display="none";}
function mp_quitar_rec(div,dia)
{var resp=JSON.parse(mp_cr_recetas);var entrante=div.split("|");var tipo=entrante[1];var dia_s=entrante[2];var receta=entrante[3];for(var v_dia in resp.armado)
{var v_recetas=resp.armado[v_dia];for(var v_dia in v_recetas)
{if(v_recetas[v_dia].clavereceta==receta&&v_recetas[v_dia].tipo==tipo&&v_recetas[v_dia].dia==dia)
{v_recetas[v_dia].clavereceta=0;v_recetas[v_dia].tipo=0;v_recetas[v_dia].dia=0;}}}
mp_cr_recetas=WA.JSON.encode(resp);elemento=document.getElementById(div);elemento.parentNode.removeChild(elemento);var nodo=WA.toDOM('mp_tipo_'+tipo+'_'+dia_s);if(!WA.toDOM(nodo).innerHTML)
WA.toDOM(nodo.parentNode).style.display='none';}
function mp_guardarrecetas(dia)
{WA.toDOM("div_btn_agregamenu").style.display="none";WA.toDOM("boton-engrane").style.display="block";WA.toDOM('boton-engrane').innerHTML+='<div id="trabajando" ><img src="'+KL.cdndomain+'/img/static/carga-verde.gif"></div>';WA.Managers.ajax.createRequest('/listeners/domenuplanner','POST','modo=agregarRecetas&dia='+dia+'&datos='+mp_cr_recetas,mp_guardarrecetasRespuesta,true);}
function mp_guardarrecetasRespuesta(request)
{var resp=JSON.parse(request.responseText);if(resp.estatus=='OK')
{WA.toDOM("boton-engrane").style.display="none";fijatitulo('icono_seccion',WA.i18n.getMessage("txtplaneador5"));confirma(WA.i18n.getMessage("txtplaneador21")+" <br>"+WA.i18n.getMessage("txtplaneador22"),WA.i18n.getMessage("txtplaneador9"),WA.i18n.getMessage("txtplaneador10"),getconfirma);}}
function mp_imprimir()
{KL.popup.show('div_imprimirMP');}
function mp_sincronizar()
{KL.popup.show('contenedor_selector_dias');}
function mp_enviar()
{KL.popup.show('div_enviar_correo');}
function mp_ayuda()
{abrirtutorialmenus(1);}
function teclaEnter(e){if(e.keyCode==13)
mpBuscaPalabra();}