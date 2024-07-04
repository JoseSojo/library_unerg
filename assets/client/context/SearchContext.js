
import React, { createContext, useState, useContext, useEffect} from 'react';

const AbstractPath = `/api`;

const defaultValue = {
    limit: 10,
    setLimit: () => {},

    valuesSearch: [],
    setValuesSearch: () => {},

    globalLoad: true,
    setGlobalLoad: () => {},

    keywords: ``,
    setKeywords: () => {},

    author: ``,
    setAuthor: () => {},

    text: ``,
    setText: () => {},

    categories: [],
    setCategories: () => {},

    programs: [],
    setPrograms: () => {},

    investigationLine: [],
    setInvestigationLine: () => {},

    works: [],
    setWorks: () => {},

    Buscar: () => {}
}

export const ContextSearch = createContext(defaultValue);

export const ProviderSearch = ({ children }) => {
    const [search, setSearch] = useState(false);
    const [globalLoad, setGlobalLoad] = useState(true);

    const [limit, setLimit] = useState(10);
    const [offset, setOffset] = useState(0);

    const [keywords, setKeywords] = useState(``);
    const [author, setAuthor] = useState(``);
    const [text, setText] = useState(``);
    const [categories, setCategories] = useState([]);
    const [programs, setPrograms] = useState([]);
    const [investigationLine, setInvestigationLine] = useState([]);

    const [works, setWorks] = useState([]); // todos los trabajos
    const [valuesSearch, setValuesSearch] = useState([]); // 

    const Buscar = () => setSearch(!search);

    const ExeuteFetch = async (path) => {
        const data = fetch(`${AbstractPath}/${path}`);
        return data;
    }

    const ValidOrArray = async (prom) => {
        const data = await prom;
        if(!data.ok) return [];
        return await data.json();
    }

    const setValueToStatus = (data, set) => {
        set(data);
    }

    useEffect(() => {
        const ExecuteRequets = async() => {
            const categoryCaountPromise = ExeuteFetch(`trabajo/category/counts`);
            const programPromise = ExeuteFetch(`trabajo/programs`);
            const investigationPromise = ExeuteFetch(`trabajo/investigationline`);
            const recentPromise = ExeuteFetch(`trabajo/recent`);

            const categoryCountValuePromise = ValidOrArray(categoryCaountPromise);
            const programValuePromise = ValidOrArray(programPromise);
            const investigationValuePromise = ValidOrArray(investigationPromise);            
            const recentValuePromise = ValidOrArray(recentPromise);                                        
            

            const categoryCount = await categoryCountValuePromise;
            const program = await programValuePromise;
            const investigation = await investigationValuePromise;            
            const recent = await recentValuePromise;                                       

            setValueToStatus(categoryCount.category, setCategories);
            setValueToStatus(program.programs, setPrograms);
            setValueToStatus(investigation.investigationLine, setInvestigationLine); 
            setValueToStatus(recent.works, setWorks);
            setGlobalLoad(false);
        }
        ExecuteRequets();
    },[]);

    useEffect(() => {
        const ExecuteRequets = async () => {
            let queryString = ``;
            let pathSearch = `trabajo`;

            valuesSearch.forEach((item) => {
                queryString +=`${item.key}=${item.value}&`;
            })

            if(!queryString) return;
            
            pathSearch += `?`;
            pathSearch += queryString.slice(0, -1);

            pathSearch += `&limit=${limit}`;
            pathSearch += `&offset=${offset}`;

            const workPromise = ExeuteFetch(pathSearch);
            const workValid = ValidOrArray(workPromise);
            const work = await workValid
            setWorks(work.works);
        }
        ExecuteRequets();

    },[search]);

    return (
        <ContextSearch.Provider value={{
            limit, setLimit,
            keywords, setKeywords,
            author, setAuthor,
            text, setText,
            categories, setCategories,
            programs, setPrograms,
            investigationLine, setInvestigationLine,
            works, setWorks,
            globalLoad, setGlobalLoad,
            valuesSearch, setValuesSearch,
            Buscar
        }}>
            {children}
        </ContextSearch.Provider>
    )
} 

export const useSearch = () => useContext(ContextSearch);
