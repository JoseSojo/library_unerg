import React from 'react';
import { useSearch } from '../../../context/SearchContext';
import CardList from '../../compound/CardList/CardList';
import { Row } from 'react-bootstrap';

export default function Main() {
    const search = useSearch();

    // console.log(search.works);

    return (
        <main className='p-5 '>
            {
                search.globalLoad
                ? <p>cargando...</p>
                : !search.works
                ? <p>No hay trabajos cargados.</p>
                : search.works.length == 0 
                ? <p>No se obtuvieron trabajos con los datos de busqueda.</p>
                : <Row>
                    {
                        search.works.map((item, i) => <CardList data={item} /> )
                    }
                </Row>
                
            }
        </main>
    );
}
