import React from "react"

const getActivityColor = (activity: any) => {
    let color = "inherit"
    if (activity.fm_spent_hour > 0) {
        color = "green"
    }
    if (activity.fm_days_ago > 3) {
        color = "#666"
    }
    return color
}

const getDaysAgoString = (daysAgo: number) => {
    let weekString = `${daysAgo}&nbsp;дней&nbsp;назад`
    if (daysAgo == 0) {
        weekString = "Сегодня"
    } else if (daysAgo == 1) {
        weekString = "Вчера"
    } else if (daysAgo < 5) {
        weekString = `${daysAgo}&nbsp;дня&nbsp;назад`
    }
    return weekString
}

const getHoursString = (hours: number) => {
    let spent = ""
    if (hours > 0) {
        spent = hours.toString(10)
        if (hours > 1) {
            if (hours > 4) {
                spent += " часов"
            } else {
                spent += " часа"
            }
        } else {
            spent += " час"
        }
    }
    return spent
}


type HomeTeamActivityItemProps = {
    key: number
    teamActivity: any
}

export default function HomeTeamActivityItem(props: HomeTeamActivityItemProps) {

    const a = props.teamActivity

    return (
        <tr>
            <td className="text-start" style={{color: getActivityColor(a)}}>
                {getDaysAgoString(a.fm_days_ago)}
                &nbsp;
                пользователь <b>{a.fm_user}</b>
                &nbsp;
                {getHoursString(a.fm_spent_hour)}
                работал над задачей
                &nbsp;
                <a className="fw-bold" href={`?section=task&task=` + a.fm_task}>[{a.fm_name}.{a.fm_descr}]</a>
                &nbsp;-&nbsp;
                <i>{a.fm_comment}</i>
            </td>
        </tr>
    )
}