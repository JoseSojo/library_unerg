import React from 'react';
// import LinkTo from '../../atoms/LinkTo/LinkTo';
// import Button from '../../atoms/Button/Button';
import { Container, Card, CardBody, Row, Col, Form } from 'react-bootstrap';

const CardCategory = ({ gosht=true, title=``, url=``, count=0 }) => {

    if(gosht===false) {
        return (
            <Card>
                <CardBody>
                    {title}
                </CardBody>
            </Card>
        )
    }

    return (
        <Col xs={12} sm={6} md={4} lg={3}>
            <Card className='shadow'>
                <CardBody>
                    <Row>
                        <Col xs={10}><h6>{title}</h6></Col>
                        <Col xs={2}><h6>{count}</h6></Col>
                    </Row>
                </CardBody>
            </Card>
        </Col>
    )
}

export default CardCategory
