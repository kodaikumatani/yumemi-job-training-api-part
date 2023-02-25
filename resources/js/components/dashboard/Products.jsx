import React, { useState, useEffect } from 'react';
import axios from "axios";
import Grid from '@mui/material/Grid';
import {
    BarChart,
    Bar,
    Cell,
    XAxis,
    YAxis,
    CartesianGrid,
    ResponsiveContainer
} from "recharts";
import { COLORS } from "../Styles";
import Legend from "./Legend";
import Title from './Title';

export default function Products() {
    const [products, setProducts] = useState([]);

    useEffect(() => {
        axios.get('/api/sales/daily/2023-02-06/products')
            .then(response => setProducts(response.data.details))
            .catch(error => console.log(error))
    }, []);

    return (
        <React.Fragment>
            <Title>Products</Title>
            <Grid container alignItems="center" justifyContent="center">
                <Grid item xs={7}>
                    <ResponsiveContainer width="90%" aspect="1.1">
                        <BarChart
                            data={products}
                            margin={{ top: 20, right: 0, bottom: 0, left: 0 }}
                            barCategoryGap={`${(7-products.length)*7}%`}
                        >
                            <CartesianGrid horizontal={true} vertical={false} />
                            <Bar dataKey="value">
                                {products.map((product, index) => (
                                    <Cell
                                        key={`cell-${index}`}
                                        fill={COLORS[index % COLORS.length]}
                                    />
                                ))}
                            </Bar>
                            <XAxis dataKey="name" tick={{fontSize:"12px"}}/>
                            {/*`${12-Math.max(products.length-3,0)*2}px`}}/>*/}
                            <YAxis tick={{fontSize: "12px"}}/>
                        </BarChart>
                    </ResponsiveContainer>
                </Grid>
                <Grid item xs={5}>
                    <Legend items={products} />
                </Grid>
            </Grid>
        </React.Fragment>
    );
}
