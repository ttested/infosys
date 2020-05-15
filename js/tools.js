function StartDT($tab='table')
{
  //console.log($tab);
  if ( $.fn.dataTable.isDataTable( $tab ) ) {
    $($tab).DataTable().destroy();
  }
	$($tab).DataTable({
 responsive: true,
  "language":{
  "processing": "Подождите...",
  "search": "Поиск:",
  "lengthMenu": "Показать _MENU_ записей",
  "info": "Записи с _START_ до _END_ из _TOTAL_ записей",
  "infoEmpty": "Записи с 0 до 0 из 0 записей",
  "infoFiltered": "(отфильтровано из _MAX_ записей)",
  "infoPostFix": "",
  "loadingRecords": "Загрузка записей...",
  "zeroRecords": "Записи отсутствуют.",
  "emptyTable": "В таблице отсутствуют данные",
  "paginate": {
    "first": "Первая",
    "previous": "Предыдущая",
    "next": "Следующая",
    "last": "Последняя"
  },
  "aria": {
    "sortAscending": ": активировать для сортировки столбца по возрастанию",
    "sortDescending": ": активировать для сортировки столбца по убыванию"
  },
  "select": {
    "rows": {
      "_": "Выбрано записей: %d",
      "0": "Кликните по записи для выбора",
      "1": "Выбрана одна запись"
    }
  }
}
 });
 
 $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
  

 $($.fn.dataTable.tables(true)).DataTable()
 .columns.adjust()
 //.responsive.recalc();
 });
 
}

function MarkDT(){
  $('table tr').on('click', function(e) {
	$b = $(this).parent().parent();  
	$($b).find('tr').removeClass('marked');
    $(this).addClass('marked');
  });
};