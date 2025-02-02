// 日時入力フォームを15分間隔で入力するようにする
document.addEventListener("DOMContentLoaded", function () {
  var dateInputs = document.querySelectorAll('input[type="datetime-local"]');

  dateInputs.forEach(function (input) {
    input.addEventListener("change", function () {
      var value = input.value;
      var minutes = new Date(value).getMinutes();

      if (minutes % 15 !== 0) {
        alert("分は15分間隔で入力してください。");
        // 最も近い15分に丸める
        var newDate = new Date(value);
        newDate.setMinutes(Math.round(minutes / 15) * 15);
        input.value = newDate.toISOString().slice(0, 16);
      }
    });
  });
});
