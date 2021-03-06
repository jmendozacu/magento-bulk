var varienForm=new Class.create();varienForm.prototype={initialize:function(formId,validationUrl){this.formId=formId;this.validationUrl=validationUrl;this.submitUrl=false;if($(this.formId)){this.validator=new Validation(this.formId,{onElementValidate:this.checkErrors.bind(this)});}
this.errorSections=$H({});},checkErrors:function(result,elm){if(!result)
elm.setHasError(true,this);else
elm.setHasError(false,this);},validate:function(){if(this.validator&&this.validator.validate()){if(this.validationUrl){this._validate();}
return true;}
return false;},submit:function(url){if(typeof varienGlobalEvents!=undefined){varienGlobalEvents.fireEvent('formSubmit',this.formId);}
this.errorSections=$H({});this.canShowError=true;this.submitUrl=url;if(this.validator&&this.validator.validate()){if(this.validationUrl){this._validate();}
else{this._submit();}
return true;}
return false;},_validate:function(){new Ajax.Request(this.validationUrl,{method:'post',parameters:$(this.formId).serialize(),onComplete:this._processValidationResult.bind(this),onFailure:this._processFailure.bind(this)});},_processValidationResult:function(transport){if(typeof varienGlobalEvents!=undefined){varienGlobalEvents.fireEvent('formValidateAjaxComplete',transport);}
var response=transport.responseText.evalJSON();if(response.error){if($('messages')){$('messages').innerHTML=response.message;}}
else{this._submit();}},_processFailure:function(transport){location.href=BASE_URL;},_submit:function(){var $form=$(this.formId);if(this.submitUrl){$form.action=this.submitUrl;}
$form.submit();}}
Validation.isVisible=function(elm){while(elm&&elm.tagName!='BODY'){if(elm.disabled)return false;if((Element.hasClassName(elm,'template')&&Element.hasClassName(elm,'no-display'))||Element.hasClassName(elm,'ignore-validate')){return false;}
elm=elm.parentNode;}
return true;}
var varienElementMethods={setHasChanges:function(element,event){if($(element)&&$(element).hasClassName('no-changes'))return;var elm=element;while(elm&&elm.tagName!='BODY'){if(elm.statusBar)
Element.addClassName($(elm.statusBar),'changed')
elm=elm.parentNode;}},setHasError:function(element,flag,form){var elm=element;while(elm&&elm.tagName!='BODY'){if(elm.statusBar){if(form.errorSections.keys().indexOf(elm.statusBar.id)<0)
form.errorSections.set(elm.statusBar.id,flag);if(flag){Element.addClassName($(elm.statusBar),'error');if(form.canShowError&&$(elm.statusBar).show){form.canShowError=false;$(elm.statusBar).show();}
form.errorSections.set(elm.statusBar.id,flag);}
else if(!form.errorSections.get(elm.statusBar.id)){Element.removeClassName($(elm.statusBar),'error')}}
elm=elm.parentNode;}
this.canShowElement=false;}}
Element.addMethods(varienElementMethods);varienWindowOnloadCache={};function varienWindowOnload(useCache){var dataElements=$$('input','select','textarea');for(var i=0;i<dataElements.length;i++){if(dataElements[i]&&dataElements[i].id){if((!useCache)||(!varienWindowOnloadCache[dataElements[i].id])){Event.observe(dataElements[i],'change',dataElements[i].setHasChanges.bind(dataElements[i]));if(useCache){varienWindowOnloadCache[dataElements[i].id]=true;}}}}}
Event.observe(window,'load',varienWindowOnload);RegionUpdater=Class.create();RegionUpdater.prototype={initialize:function(countryEl,regionTextEl,regionSelectEl,regions,disableAction,clearRegionValueOnDisable)
{this.countryEl=$(countryEl);this.regionTextEl=$(regionTextEl);this.regionSelectEl=$(regionSelectEl);this.config=regions['config'];delete regions.config;this.regions=regions;this.disableAction=(typeof disableAction=='undefined')?'hide':disableAction;this.clearRegionValueOnDisable=(typeof clearRegionValueOnDisable=='undefined')?false:clearRegionValueOnDisable;if(this.regionSelectEl.options.length<=1){this.update();}
else{this.lastCountryId=this.countryEl.value;}
this.countryEl.changeUpdater=this.update.bind(this);Event.observe(this.countryEl,'change',this.update.bind(this));},_checkRegionRequired:function()
{var label,wildCard;var elements=[this.regionTextEl,this.regionSelectEl];var that=this;if(typeof this.config=='undefined'){return;}
var regionRequired=this.config.regions_required.indexOf(this.countryEl.value)>=0;elements.each(function(currentElement){if(!currentElement){return;}
Validation.reset(currentElement);label=$$('label[for="'+currentElement.id+'"]')[0];if(label){wildCard=label.down('em')||label.down('span.required');var topElement=label.up('tr')||label.up('li');if(!that.config.show_all_regions&&topElement){if(regionRequired){topElement.show();}else{topElement.hide();}}}
if(label&&wildCard){if(!regionRequired){wildCard.hide();}else{wildCard.show();}}
if(!regionRequired||!currentElement.visible()){if(currentElement.hasClassName('required-entry')){currentElement.removeClassName('required-entry');}
if('select'==currentElement.tagName.toLowerCase()&&currentElement.hasClassName('validate-select')){currentElement.removeClassName('validate-select');}}else{if(!currentElement.hasClassName('required-entry')){currentElement.addClassName('required-entry');}
if('select'==currentElement.tagName.toLowerCase()&&!currentElement.hasClassName('validate-select')){currentElement.addClassName('validate-select');}}});},update:function()
{if(this.regions[this.countryEl.value]){if(this.lastCountryId!=this.countryEl.value){var i,option,region,def;def=this.regionSelectEl.getAttribute('defaultValue');if(this.regionTextEl){if(!def){def=this.regionTextEl.value.toLowerCase();}
this.regionTextEl.value='';}
this.regionSelectEl.options.length=1;for(regionId in this.regions[this.countryEl.value]){region=this.regions[this.countryEl.value][regionId];option=document.createElement('OPTION');option.value=regionId;option.text=region.name.stripTags();option.title=region.name;if(this.regionSelectEl.options.add){this.regionSelectEl.options.add(option);}else{this.regionSelectEl.appendChild(option);}
if(regionId==def||region.name.toLowerCase()==def||region.code.toLowerCase()==def){this.regionSelectEl.value=regionId;}}}
if(this.disableAction=='hide'){if(this.regionTextEl){this.regionTextEl.style.display='none';this.regionTextEl.style.disabled=true;}
this.regionSelectEl.style.display='';this.regionSelectEl.disabled=false;}else if(this.disableAction=='disable'){if(this.regionTextEl){this.regionTextEl.disabled=true;}
this.regionSelectEl.disabled=false;}
this.setMarkDisplay(this.regionSelectEl,true);this.lastCountryId=this.countryEl.value;}else{if(this.disableAction=='hide'){if(this.regionTextEl){this.regionTextEl.style.display='';this.regionTextEl.style.disabled=false;}
this.regionSelectEl.style.display='none';this.regionSelectEl.disabled=true;}else if(this.disableAction=='disable'){if(this.regionTextEl){this.regionTextEl.disabled=false;}
this.regionSelectEl.disabled=true;if(this.clearRegionValueOnDisable){this.regionSelectEl.value='';}}else if(this.disableAction=='nullify'){this.regionSelectEl.options.length=1;this.regionSelectEl.value='';this.regionSelectEl.selectedIndex=0;this.lastCountryId='';}
this.setMarkDisplay(this.regionSelectEl,false);}
varienGlobalEvents.fireEvent("address_country_changed",this.countryEl);this._checkRegionRequired();},setMarkDisplay:function(elem,display){if(elem.parentNode.parentNode){var marks=Element.select(elem.parentNode.parentNode,'.required');if(marks[0]){display?marks[0].show():marks[0].hide();}}}}
regionUpdater=RegionUpdater;Event.pointerX=function(event){try{return event.pageX||(event.clientX+(document.documentElement.scrollLeft||document.body.scrollLeft));}
catch(e){}}
Event.pointerY=function(event){try{return event.pageY||(event.clientY+(document.documentElement.scrollTop||document.body.scrollTop));}
catch(e){}}
SelectUpdater=Class.create();SelectUpdater.prototype={initialize:function(firstSelect,secondSelect,selectFirstMessage,noValuesMessage,values,selected)
{this.first=$(firstSelect);this.second=$(secondSelect);this.message=selectFirstMessage;this.values=values;this.noMessage=noValuesMessage;this.selected=selected;this.update();Event.observe(this.first,'change',this.update.bind(this));},update:function()
{this.second.length=0;this.second.value='';if(this.first.value&&this.values[this.first.value]){for(optionValue in this.values[this.first.value]){optionTitle=this.values[this.first.value][optionValue];this.addOption(this.second,optionValue,optionTitle);}
this.second.disabled=false;}else if(this.first.value&&!this.values[this.first.value]){this.addOption(this.second,'',this.noMessage);}else{this.addOption(this.second,'',this.message);this.second.disabled=true;}},addOption:function(select,value,text)
{option=document.createElement('OPTION');option.value=value;option.text=text;if(this.selected&&option.value==this.selected){option.selected=true;this.selected=false;}
if(select.options.add){select.options.add(option);}else{select.appendChild(option);}}}
FormElementDependenceController=Class.create();FormElementDependenceController.prototype={initialize:function(elementsMap,config)
{if(config){this._config=config;}
for(var idTo in elementsMap){for(var idFrom in elementsMap[idTo]){if($(idFrom)){Event.observe($(idFrom),'change',this.trackChange.bindAsEventListener(this,idTo,elementsMap[idTo]));this.trackChange(null,idTo,elementsMap[idTo]);}else{this.trackChange(null,idTo,elementsMap[idTo]);}}}},_config:{levels_up:1},trackChange:function(e,idTo,valuesFrom)
{var shouldShowUp=true;for(var idFrom in valuesFrom){var from=$(idFrom);if(valuesFrom[idFrom]instanceof Array){if(!from||valuesFrom[idFrom].indexOf(from.value)==-1){shouldShowUp=false;}}else{if(!from||from.value!=valuesFrom[idFrom]){shouldShowUp=false;}}}
if(shouldShowUp){var currentConfig=this._config;$(idTo).up(this._config.levels_up).select('input','select','td').each(function(item){if((!item.type||item.type!='hidden')&&!($(item.id+'_inherit')&&$(item.id+'_inherit').checked)&&!(currentConfig.can_edit_price!=undefined&&!currentConfig.can_edit_price)){item.disabled=false;}});$(idTo).up(this._config.levels_up).show();}else{$(idTo).up(this._config.levels_up).select('input','select','td').each(function(item){if((!item.type||item.type!='hidden')&&!($(item.id+'_inherit')&&$(item.id+'_inherit').checked)){item.disabled=true;}});$(idTo).up(this._config.levels_up).hide();}}}