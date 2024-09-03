import React from 'react';
import Header from "./UI/organics/Header/Header";
import { ProviderSearch } from './context/SearchContext';
import Brand from './UI/organics/Brand/Barnd';
import Main from './UI/organics/Main/Main';
import { ProviderModal } from './context/ModalContext';
import ModalTemplate from './UI/templates/ModalTemplate/ModalTemplate';
// import { Card, Col, Row } from 'antd';
// import '../lib/bootstrap/bootstrap-grid.css';

const App = (props) => {
    
    return (
        <>
            <ProviderSearch>
                <ProviderModal>
                    <ModalTemplate />
                    <Header />
                    <Main />
                </ProviderModal>
            </ProviderSearch>
        </>
    )
}

export default App;
