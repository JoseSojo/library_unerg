import React, {useState} from 'react';
import Button from '../../atoms/Button/Button';
import Textarea from '../../atoms/Textarea/Input';
import { useSearch } from '../../../context/SearchContext';

export default function ItemCategory({ name, change, valueSearch, ico, list }) {
    const [active, setActive] = useState(false);
    const ActiveController = () => setActive(!active);

    const clsTextarea = `outline-none p-2 rounded border shadow text-xs mt-2 min-h-10 max-h-36 w-full text-gray-700 font-semibold`;
    const clsBtn = `${active ? `text-white bg-[#2c698d] hover:bg-[#2c698d]` : `hover:text-white hover:bg-[#2c698d]`} w-full flex items-center px-4 py-2.5 text-sm font-medium text-gray-900 transition-all duration-200 rounded-lg group`;

    return (
        <div className="">
            <Button 
                click={ActiveController}
                type='button'
                customClass={clsBtn}>
                <i className={`bi ${ico} text-lg mr-2`}></i>    
                {name}
            </Button>
            {
                active && <>
                <Textarea 
                    change={change}
                    customClass={clsTextarea}
                    name="value"
                    value={valueSearch}
                />
                {
                    list &&
                    <ul>
                        {
                            list.map((item, i) => (
                                <Button
                                    customClass="w-full cursor-pointer text-center text-xs font-bold rounded-[20px] py-1 hover:text-white hover:bg-[#2c698d]"
                                    click={()=> change(item.name)}
                                    key={item.id}
                                    type='button'
                                >
                                    {item.name}
                                </Button>
                            ))
                        }
                    </ul>
                }
            </>
            }
        </div>
    )
}  
