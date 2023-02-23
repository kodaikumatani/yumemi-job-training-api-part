import * as React from 'react';
import * as ReactDOM from 'react-dom/client';
import DashboardContent from './pages/Dashboard';

ReactDOM.createRoot(document.querySelector("#app")).render(
    <React.StrictMode>
        <DashboardContent />
    </React.StrictMode>
);
