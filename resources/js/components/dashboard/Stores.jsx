import * as React from 'react';
import axios from 'axios';
import Grid from '@mui/material/Grid';
import {
    PieChart,
    Pie,
    Cell,
    Label,
    ResponsiveContainer
} from "recharts";
import { COLORS } from "../Styles";
import Legend from "./Legend";
import Title from './Title';

export default function Stores(props) {
    const { date } = props;
    const [stores, setStores] = React.useState([]);
    const total = new Intl.NumberFormat().format(stores.reduce(function (sum, element) {
        return sum + element.value;
    }, 0));

    React.useEffect(() => {
        axios.get(`/api/sales/daily/${date}/stores`)
            .then(response => setStores(response.data.details))
            .catch(error => console.log(error))
    }, [])

    return (
        <React.Fragment>
            <Title>Sales</Title>
            <Grid container alignItems="center" minHeight="200px">
                <Grid item xs={5} >
                    <ResponsiveContainer width="90%" aspect="1">
                        <PieChart>
                            <Pie
                                data={stores}
                                innerRadius="75%"
                                outerRadius="90%"
                                fill="#8884d8"
                                paddingAngle={2}
                                dataKey="value"
                            >
                                <Label position="center" fontSize="130%">
                                    {"¥" + total}
                                </Label>
                                {stores.map((store, index) => (
                                    <Cell
                                        key={`cell-${index}`}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Pie>
                        </PieChart>
                    </ResponsiveContainer>
                </Grid>
                <Grid item xs={7}>
                    <Legend items={stores} />
                </Grid>
            </Grid>
        </React.Fragment>
    );
}
