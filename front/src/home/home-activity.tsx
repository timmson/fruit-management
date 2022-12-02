import React from "react"

type HomeActivityProps = {
    activities: any[]
}

export default function HomeActivity(props: HomeActivityProps) {
    const activities = props.activities

    return (
        <>
            <h3>Моя активность</h3>
            <table className="container w-100">
                <thead>
                <tr className="fw-bold">
                    <th>Задача</th>
                    <th>Статус</th>
                    <th>ПН</th>
                    <th>ВТ</th>
                    <th>СР</th>
                    <th>ЧТ</th>
                    <th>ПТ</th>
                </tr>
                </thead>
                <tbody>
                {activities}
                <tr className="fw-bold">
                    <td colSpan="2" className="text-end">
                        Итого
                    </td>
                    <td className="text-center">$mon</td>
                    <td className="text-center">$tue</td>
                    <td className="text-center">$wen</td>
                    <td className="text-center">$th</td>
                    <td className="text-center">$fr</td>
                </tr>
                </tbody>
            </table>
        </>
    )
}