import React from 'react';
import Header from "./UI/organics/Header/Header";
import { ProviderSearch } from './context/SearchContext';
import Brand from './UI/organics/Brand/Barnd';
import Main from './UI/organics/Main/Main';
// import { Card, Col, Row } from 'antd';
// import '../lib/bootstrap/bootstrap-grid.css';

const App = (props) => {
    
    return (
        <ProviderSearch>
            <Header />
            <Main />
        </ProviderSearch>
    )
}

export default App;
