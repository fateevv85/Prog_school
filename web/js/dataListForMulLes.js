$('#modal').click(()=>{
  const start = new Date ($('#lesson-date_start').val());
  const number = parseInt($('#lesson-count').val());
  const interval = parseInt($('#lesson-next').val());

  let dateList = [];
  let dayInt = 0;
  for (let i = 1; i <= number; i++) {

    let date = new Date();
    date.setDate(start.getDate()+ dayInt);
    dateList.push(date.getDate() + '.' + (date.getMonth()+1) + '.' + date.getFullYear());
    dayInt += interval;
  }

  $('#date-list').remove();

  let ul = $('<ul/>', {
    id: 'date-list'
  });

  dateList.forEach((el,i)=>{
    let li = $('<li/>');
    let isStart = (i===0)?' стартовое':'';

    li.text('Занятие №'+ ++i + ': ' + el + isStart);
    ul.append(li);
  });

  $('#result').append(ul);
});
