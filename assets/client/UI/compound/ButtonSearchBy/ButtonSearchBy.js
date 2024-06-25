import React from 'react';
import { useSearch } from '../../../context/SearchContext';
import Button from '../../atoms/Button/Button';

const ButtonSearchBy = () => {     

    const contextSeacrh = useSearch();

    return (

        <Button
            customClass="w-full text-white bg-[#2c698d] rounded-[20px] outline-none py-2"
            click={()=>{console.log(contextSeacrh.author, contextSeacrh.keywords, contextSeacrh.run)}}
            type='button'
        >
            buscar
        </Button>

    )
}
export default ButtonSearchBy;
