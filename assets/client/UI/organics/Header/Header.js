import React, {useState} from 'react';
// import Navbar from '../../molecules/Navbar/Navbar';
import { 
    Container, Col, Row, Navbar,
} from 'react-bootstrap';
import Search from '../../compound/Search/Search';
import Brand from '../Brand/Barnd';
import { useSearch } from '../../../context/SearchContext';
import CardCategory from '../../compound/CardCategory/CardCategory';

const Header = () => {

    const search = useSearch();

    return (
        <header 
            style={{ 
                background: "url('/wallpaper.jpg')", 
                backgroundPosition:'center center',
                backgroundRepeat: 'no-repeat'
            }} 
            className='p-3 py-5 h-100 d-flex flex-column justify-content-between position-relative'
        >
            <Row>
                <Col lg={10} className='mx-auto'>
                    <Navbar bg='light' className='p-3 rounded-lg'>
                        <Container fluid>
                            <Col lg={6}>
                                <Navbar.Brand href='/'>
                                    BIBLIOTECA
                                </Navbar.Brand>
                            </Col>
                            <Col lg={6}>
                                <Row>
                                    <Col xs={2}>
                                        <Navbar.Text>
                                            <a href='/login' className='nav-link'>entrar</a>
                                        </Navbar.Text>
                                    </Col>
                                    <Col xs={10}><Search customClass='' /></Col>
                                </Row>
                            </Col>
                        </Container>
                    </Navbar>
                </Col>
            </Row>

            <Row>
                <Col lg={10} className='mx-auto'>
                    <Brand />
                </Col>
            </Row>

            <Row 
                className='w-100 position-absolute flex' 
                style={{
                    bottom: '-35px'
                }}
            >
                {
                    search.categories.length > 0 && 
                    search.categories.map((item, i) => (
                        <CardCategory count={item.count} key={item.id} title={item.name} url='' />
                    ))
                }
            </Row>
        </header>
    )
}

export default Header;
