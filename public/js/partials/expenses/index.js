!function(e){var t={};function n(a){if(t[a])return t[a].exports;var o=t[a]={i:a,l:!1,exports:{}};return e[a].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,a){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(n.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(a,o,function(t){return e[t]}.bind(null,o));return a},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="/",n(n.s=8)}({"0c+O":function(e,t){applyCleave($("[name=value]"),cleaveValueBRL),applyCleave($("[name*=date]"),cleaveDate),applyCleave($("[name*=dia]"),cleaveDate);var n=document.querySelector("#editFormModal .modal-body"),a=new MutationObserver((function(e){applyCleave($("[name=value]"),cleaveValueBRL),applyCleave($("[name=date]"),cleaveDate)}));$(document).on("input","input[type=file]",(function(){var e=$(this)[0].files||null,t=[];e.length>0?(Object.entries(e).forEach((function(e){t.push(e[1].name)})),$(this).next(".custom-file-label").html(t.reverse().join(", "))):$(this).next(".custom-file-label").html("Selecione o comprovante")})),a.observe(n,{attributes:!0,childList:!0,characterData:!0}),$("#btnAddExpenseType").on("click",(function(e){e.preventDefault(),$btn=$(this),loadingBtn($btn,!0),axios.post(getLocationURL()+"/tipo-de-despesa",{expense_type:$("[name=expense_type]").val()}).then((function(e){$(".modal-body .list-group").append(e.data.view),$("[name=expense_type]").val("")})).catch((function(e){dispatchErrorMessages(e.response.data.errors)})).then((function(){loadingBtn($btn,!1)}))})),$(document).on("click",".btn-delete-expense-type",(function(e){var t=this;e.preventDefault(),Swal.fire({icon:"error",iconHtml:'<i class="fas fa-exclamation-triangle"></i>',title:"Cuidado",html:'\n    <div class="text-center">\n      Ao deletar esse tipo de despesa você terá que alterar todas as despesas que estavam cadastradas nesse tipo para um tipo existente\n      </div>\n      <div class="font-weight-bold text-center mt-3">Você tem certeza?</div> \n    ',showCancelButton:!0,confirmButtonText:"Tenho",cancelButtonText:"Cancelar"}).then((function(e){if(e.isConfirmed){var n=$(t).parents("[data-id]").attr("data-id");$(".modal-body").prepend($('\n        <div class="loading-page">\n            <div class="spinner-border text-primary"></div>\n        </div>\n      ')),axios.delete(getLocationURL()+"/tipo-de-despesa/"+n+"/deletar").then((function(e){$("[data-id="+n+"]").remove()})).catch((function(e){})).then((function(e){$(".loading-page").remove()}))}}))})),$(document).on("click",".btn-edit-expense-type",(function(e){e.preventDefault();var t=$(this).parents("[data-id]").attr("data-id"),n=$(this).parents("[data-id]").find(".expense-type-name").text().trim(),a=$('\n    <div class="col px-0">\n      <form>\n        <div class="input-group">\n          <input class="form-control" name="expense_type_updated" value="'.concat(n,'">\n          <div class="input-group-append">\n            <button class="btn btn-outline-primary btn-update-expense-type">Concluído</button>\n          </div>\n        </div>\n      </form>\n    </div>\n  '));$(this).parents("[data-id="+t+"]").html(a),$("[name=expense_type_updated]").focus()})),$(document).on("click",".btn-update-expense-type",(function(e){e.preventDefault();var t=$(this),n=$(this).parents("[data-id]").attr("data-id");loadingBtn(t,!0),axios.patch(getLocationURL()+"/tipo-de-despesa/"+n,{expense_type_updated:$("[name=expense_type_updated]").val()}).then((function(e){$("[data-id="+n+"]").html($(e.data.view).children())})).catch((function(e){dispatchErrorMessages(e.response.data.errors)})).then((function(){loadingBtn(t,!1)}))})),$(".btn-delete").on("click",(function(e){e.preventDefault();var t=$(this).parents("[data-id]").attr("data-id"),n=$(this);Swal.fire({icon:"error",iconHtml:'<i class="fas fa-trash-alt"></i>',title:"Tem certeza?",html:'\n    <div class="text-center">\n      Isso irá deletar a despesa\n      </div>\n    ',showCancelButton:!0,confirmButtonText:"Tenho",cancelButtonText:"Cancelar"}).then((function(e){e.isConfirmed&&(loadingBtn(n,!0),axios.delete(getLocationURL()+"/"+t+"/deletar").then((function(e){window.location=e.data.redirect,loadingBtn(n,!1)})))}))})),$("#btnCreateUniqueExpense").on("click",(function(e){e.preventDefault(),$btn=$(this),loadingBtn($btn,!0);var t=new FormData($(this).parents("form").get(0));axios.post(getLocationURL()+"/cadastro",t).then((function(e){window.location=e.data.redirect})).catch((function(e){dispatchErrorMessages(e.response.data.errors,"#createFormModal"),loadingBtn($btn,!1)}))})),$(document).on("click","#btnUpdateExpense",(function(e){e.preventDefault();var t=$(this).attr("data-id"),n=$(this);loadingBtn(n,!0);var a=new FormData($(this).parents("form").get(0));axios.post(getLocationURL()+"/"+t,a).then((function(e){window.location=e.data.redirect})).catch((function(e){dispatchErrorMessages(e.response.data.errors,"#editFormModal"),loadingBtn(n)}))})),$(".btn-edit").on("click",(function(){var e=$(this).parents("[data-id]").attr("data-id");axios.get(getLocationURL()+"/"+e+"/get-edit-form").then((function(e){$("#editFormModal .modal-body").html(e.data.view)}))})),$("#btnGenerateReport").on("click",(function(e){e.preventDefault(),axios.get(getLocationURL()+"/relatorio",{params:{dia_inicial:$("[name=dia_inicial]").val(),dia_final:$("[name=dia_final]").val()}}).then((function(e){$("#reportForm").submit()})).catch((function(e){dispatchErrorMessages(e.response.data.errors)}))})),$(document).on("click","#deleteReceipt",(function(e){e.preventDefault();var t=$(this).parents("[data-id]").attr("data-id"),n=$(this);axios.delete(getLocationURL()+"/"+t+"/delete-receipt").then((function(e){console.log(e.data),n.parents("[data-id]").remove()})).catch((function(e){console.log(e.response)}))})),$(".btn-view-receipt").on("click",(function(e){e.preventDefault();var t=$(this).parents("[data-id]").attr("data-id");axios.get(getLocationURL()+"/"+t+"/get-view-receipt").then((function(e){$("#viewReceiptModal .modal-body").html(e.data.view)})).catch((function(e){console.log(e.response)}))}))},8:function(e,t,n){e.exports=n("0c+O")}});