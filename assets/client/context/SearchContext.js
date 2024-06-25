
import React, { createContext, useState, useContext} from 'react';

const ThemeContext = createContext('light');
const AuthContext = createContext(null);

const defaultValue = {
    keywords: ``,
    setKeywords: () => {},
    author: ``,
    setAuthor: () => {},
    run: ``,
    setRun: () => {},
    text: ``,
    setText: () => {},
}

export const ContextSearch = createContext(defaultValue);

export const ProviderSearch = ({ children }) => {

    const [keywords, setKeywords] = useState(``);
    const [author, setAuthor] = useState(``);
    const [run, setRun] = useState(``);
    const [text, setText] = useState(``);

    return (
        <ContextSearch.Provider value={{
            keywords, setKeywords,
            author, setAuthor,
            run, setRun,
            text, setText
        }}>
            {children}
        </ContextSearch.Provider>
    )
} 

export const useSearch = () => useContext(ContextSearch);
