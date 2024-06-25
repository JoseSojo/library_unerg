import React from 'react';
import Header from "./UI/organics/Header/Header";
import Main from './UI/organics/Main/Main';
import { ProviderSearch } from './context/SearchContext';
import MainSlideCategory from './UI/molecules/MainSlideCategory/MainSlideCategory';

const App = (props) => {
    
    return (
        <ProviderSearch>
            <div className="flex flex-1 bg-gray-50">
                <div className="hidden md:flex md:w-64 md:flex-col">
                    <MainSlideCategory />
                </div>
                <div className="flex flex-col flex-1">
                    <Header />
                    <Main />
                </div>
            </div>
        </ProviderSearch>
    )
}

export default App;
