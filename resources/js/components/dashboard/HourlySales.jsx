import * as React from "react";
import axios from "axios";
import {
    BarChart,
    Bar,
    XAxis,
    YAxis,
    CartesianGrid,
    ResponsiveContainer
} from "recharts";
import Title from './Title';

export default function HourlySales(props) {
    const { date } = props;
    const [hours, setHours] = React.useState([]);

    React.useEffect(() => {
        axios.get(`/api/sales/${date}/hourly`)
            .then(response => setHours(response.data.summary))
            .catch(error => console.log(error))
    }, [])

    return (
        <React.Fragment>
            <Title>HourlySales</Title>
            <ResponsiveContainer width="95%" aspect="3">
                <BarChart
                    data={hours}
                    margin={{ top: 30, right: 0, bottom: 0, left: 0 }}
                    barCategoryGap={"20%"}
                >
                    <CartesianGrid horizontal={true} vertical={false} />
                    <Bar dataKey="value" fill="#1492C9" />
                    <XAxis dataKey="hour" />
                    <YAxis />
                </BarChart>
            </ResponsiveContainer>
        </React.Fragment>
    );
}
