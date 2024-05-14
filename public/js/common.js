function getFormData(dom) {
  var formDataArr = $(dom).serializeArray()
  var formData = {}
  $.each(formDataArr, function (index, item) {
    formData[item.name] = item.value
  })
  return formData
}
