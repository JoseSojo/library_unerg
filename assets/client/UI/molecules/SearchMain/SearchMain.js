import React, {useState} from 'react';
import Button from '../../atoms/Button/Button';
import Input from '../../atoms/Input/Input';
import Subtitle from '../../atoms/Subtitle/Subtitle';

import Image from '../../atoms/Image/Image';

const SearchMain = ({LOGO}) => {

    const [valueSearch, setValueSearch] = useState(``);

    return <div className="relative flex w-[95%] lg:w-[70%] flex-col rounded-xl  text-gray-700 shadow-lg shadow-gray-300">
        <div className="relative mx-4 -mt-6 h-36 overflow-hidden rounded-xl  text-white shadow shadow-gray-3 bg-gradient-to-b from-[#f7fbfb] to-[#bae8e8]">
            <Image
                alternative="Logo unerg"
                customClass="h-[100%] m-auto"
                path={LOGO}
            />
        </div>
        <form className="p-6 grid place-items-center">
            <Subtitle 
                customClass="mb-2 block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased"
                subtitle="Buscar"
            />
            <Input 
                change={setValueSearch}
                customClass="shadow shadow-gray-300 border outline-none w-full rounded-[20px] py-2 px-5 text-gray-700 text-sm"
                name="searchMain"
                value={valueSearch}
                type='text'
            />
            <div className="w-full"></div>
            <Button 
                type="submit" 
                customClass="mt-5 rounded-[20px] bg-[#bae8e8] py-3 px-6 text-center font-mono text-sm font-bold text-white shadow-md shadow-blue-500/20 transition-all duration-400 hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
            >
                <i className="bi bi-search mr-2 text-black"></i>
                <b className="text-black">BUSCAR</b>
            </Button>
        </form>
    </div>
}

export default SearchMain;

