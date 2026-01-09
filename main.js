// 今日の日付を取得
const today = new Date()
const today_string = `${today.getFullYear()}-${(String(today.getMonth() + 1)).padStart(2, "0")}-${String(today.getDate()).padStart(2, "0")}`
// 現在表示中のカレンダー
let current_day = ""
let schedules = ""


function toYMD(date) {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, "0")}-${String(date.getDate()).padStart(2, "0")}`
}
/**
 * 基準日に沿ってカレンダーを表示する関数
 * @param {Date} target_day カレンダー作成基準日
 */
function create_table(target_day, schedules) {
    // function create_table(target_day) {
    // 月の1日
    const first = new Date(target_day.getFullYear(), target_day.getMonth(), 1);
    // 月の最終日
    const lastDate = new Date(target_day.getFullYear(), target_day.getMonth() + 1, 0).getDate();
    // 月の1日の曜日
    const startWeekday = first.getDay();


    // 画面の表示月更新
    $("#current-month").text(`${target_day.getMonth() + 1}月`);
    // カレンダーHTML初期化
    $(".calender tbody").html("");
    $(".schedule").html("");
    let table_h = ""

    let day = 1
    // 週ループ
    for (i = 0; i < 6; i++) {
        table_h += `<tr>`
        // 日ループ
        for (j = 0; j < 7; j++) {
            let today_class = ""
            const target_day2 = new Date(target_day.getFullYear(), target_day.getMonth(), day, today.getHours(), today.getMinutes(), today.getSeconds(), today.getMilliseconds())

            if ((i * 7 + j < startWeekday) || (day > lastDate)) {
                // 前月・次月にかかる部分は省略
                table_h += `<td class="calender-td"></td>`
            } else {
                // 今日の日付と同じ場合はCSS適用
                if (target_day2.getTime() === today.getTime()) {
                    today_class = " today"
                }
                // 日付idを変数として保存
                set_id = `${target_day.getFullYear()}-${(target_day.getMonth() + 1).toString().padStart(2, "0")}-${day.toString().padStart(2, "0")}`
                // 追加するHTML要素の作成
                table_h += `<td class="calender-td ${today_class}" id="${set_id}">${day}</td>`
                day++
            }
        }
        table_h += `</tr>`

        // 6週がない場合は省略
        if (day > lastDate) {
            break
        }
    }
    // HTML表示
    $(".calender tbody").html(table_h);

    let sidebar_id = "side-"
    let current_day = ""
    // 保存された予定１件ずつ取得
    schedules.forEach(schedule => {
        let schedule_date = schedule.schedule_start.substring(0, 10)
        let schedule_time_start = schedule.schedule_start.substring(11, 16)
        let schedule_time_end = schedule.schedule_end.substring(11, 16)


        // カレンダーに予定を追加
        $(`#${schedule_date}`).append(`
            <p class="calender-content">${schedule_time_start}- ${schedule.schedule_title}</p>
            `);
        // 取得した予定が今日以降の場合
        if (schedule_date >= today_string) {
            // 前回の日付と同日じゃない場合
            if (current_day !== schedule_date) {
                // サイドバーに日付を追加
                sidebar_id = `side-${schedule_date}`
                $(".schedule").append(`
                    <div class="schedule-day" id="${sidebar_id}">
                        <h3 class="sidebar-date">${schedule_date}</h3>
                    </div>
                `);
            }
            // サイドバーに予定を追加
            $(`#${sidebar_id}`).append(`
                <div class="schedule-day">
                    <p><small>${schedule_time_start}-${schedule_time_end}</small>  ${schedule.schedule_title}</p>
                </div>
            `);
        }
        // 今回の日付で更新
        current_day = schedule_date
    });
}

// アクセス時に今月のカレンダーを作成
$(window).on("load", function () {
    $("#schedule-date-start").val(today_string);
    // 表示中の月を更新
    current_day = today.getTime()
    if ($("#script").attr("data-param") !== "") {
        schedules = JSON.parse($("#script").attr("data-param"));
    }
    // カレンダー作成
    create_table(today, schedules)
    // create_table(today)
});

// 前月のカレンダーに更新
$("#pre_month").on("click", function () {
    // 表示中の月を取得
    let pre_month = new Date(current_day)
    // 前月に移動
    pre_month.setMonth(pre_month.getMonth() - 1)
    // 表示中の月を更新
    current_day = pre_month.getTime()
    // カレンダー作成
    create_table(pre_month, schedules)
});

// 次月のカレンダーに更新
$("#next_month").on("click", function () {
    // 表示中の月を取得
    let next_month = new Date(current_day)
    // 前月に移動
    next_month.setMonth(next_month.getMonth() + 1)
    // 表示中の月を更新
    current_day = next_month.getTime()
    // カレンダー作成
    create_table(next_month, schedules)
});