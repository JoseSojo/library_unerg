import React from 'react';
import ItemCategory from '../../compound/ItemsCategory/ItemCategory';
import { useSearch } from '../../../context/SearchContext';
import Button from '../../atoms/Button/Button';
import ButtonSearchBy from '../../compound/ButtonSearchBy/ButtonSearchBy';
import Title from '../../atoms/Title/Title';

const MainSlideCategory = () => {     

    const contextSeacrh = useSearch();

    return (
        <div className="fixed h-screen flex flex-col flex-grow pt-5 overflow-y-auto bg-white w-72">
            <div className="px-4 mt-6">
                <Title customClass="text-md font-mono font-black text-gray-900" title="BIBLIOTECA UNERG" />

                <hr className="border-gray-200" />
            </div>

            <div className="flex flex-col flex-1 px-3 mt-6">
                <div className="space-y-4">
                    <nav className="flex-1 space-y-2">
                        <span className="font-black text-gray-800 text-sm">Filtro</span>

                        <ItemCategory
                            ico="bi-key"
                            change={contextSeacrh.setKeywords}
                            name="Palabras clave"
                            valueSearch={contextSeacrh.keywords}
                        />

                        <ItemCategory
                            ico="bi-person-bounding-box"
                            change={contextSeacrh.setAuthor}
                            name="Autor"
                            valueSearch={contextSeacrh.author}
                        />

                        <ItemCategory
                            ico="bi-house"
                            change={contextSeacrh.setRun}
                            name="Carreras"
                            valueSearch={contextSeacrh.run}
                            list={contextSeacrh.programs}
                        />

                        <ButtonSearchBy />
                    </nav>

                    <hr className="border-gray-200" />

                    <nav className="flex-1 space-y-2 flex flex-col gap-3">
                        <span className="font-black text-gray-800 text-sm">Accesos rápidos</span>

                        <div><Button  
                            click={()=>{}}
                            type='button'
                            customClass={``}
                        >
                            <i className="bi bi-clock text-lg mr-2"></i>    
                            Recientes
                        </Button></div>

                        <div><Button 
                            click={()=>{}}
                            type='button'
                            customClass={``}
                        >
                            <i className="bi bi-star text-lg mr-2"></i>    
                            Destacados
                        </Button></div>

                        <div><Button 
                            click={()=>{}}
                            type='button'
                            customClass={``}
                        >
                            <i className="bi bi-list-ol text-lg mr-2"></i>    
                            Todos
                        </Button></div>
                    </nav>
                </div>
            </div>
        </div>

    )
}
export default MainSlideCategory;
