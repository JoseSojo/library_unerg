import React, {useState} from 'react';
import Input from '../../atoms/Input/Input';
import Button from '../../atoms/Button/Button';

const Search = ({ customClass='' }) => {
    
    const [active, setActive] = useState(false);
    const [valueSearch, setValueSearch] = useState(``);

    const ButtonController = () => setActive(!active);
    const SubmitController = (e) => {
        e.preventDefault();

        console.log(valueSearch.length);
        if(valueSearch.length < 5) return; 

        alert(`buscando`)
        // ButtonController();
    }

    return <div
        className={`${customClass} flex`}
    >
        { active 
            ?<div className='h-full p-0 duration-400'>
                <form className='flex m-0' onSubmit={SubmitController}>
                <Input 
                    customClass='border outline-none px-5 py-1 rounded-[20px]' 
                    name='search' 
                    change={setValueSearch} 
                    type='text' 
                    value={valueSearch}
                    /> 
                <Button 
                    customClass='outline-none rounded-full mr-4 bg-[#2c698d] w-9 h-9 font-bold text-white' 
                    name='lupa'
                    type='submit'
                >
                    <i className="bi bi-search"></i>
                </Button>
                </form>
            </div>
            :<Button 
                click={ButtonController}
                customClass='outline-none rounded-full mr-4 bg-[#2c698d] w-9 h-9 font-bold text-white'
                type='button'
            >
                <i className="bi bi-search"></i>
            </Button>
        }
    </div>
}

export default Search;

