import { Text } from '@consta/uikit/Text';
import { Card } from '@consta/uikit/Card';
import { Button } from '@consta/uikit/Button';
import { useCallback, useContext, useEffect } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useGetDriversQuery } from '@/entities/driver/api';
import { apiEndpoints } from '@/shared/const/apiEndpoins';
import { EchoContext } from '@/entities/echo/echoContext';
import { useLazyGetConnectordByIdQuery } from '@/entities/connectors/api';
import { setConnectorId } from '@/entities/connectors/model/connectorSlice';
import { AuthContext } from '@/features/account/ui/AuthContext';
import styles from '../style/styles.module.scss';

const Banks = () => {
    const dispatch = useDispatch();

    const { channel } = useContext(EchoContext);
    const { getStateId } = useContext(AuthContext);

    const { stateId } = useSelector((state) => state.account);
    const { data, error, isLoading, refetch } = useGetDriversQuery();

    const [getConnectordById] = useLazyGetConnectordByIdQuery();

    const connectBank = useCallback(
        ({ driver }) => {
            window.open(apiEndpoints.drivers.prepareStateNotApi(driver, stateId), '_blank');
        },
        [stateId],
    );

    const getConnectorsAccount = useCallback(
        async (id) => {
            await getConnectordById(id);
        },
        [getConnectordById],
    );

    const refreshState = useCallback(() => {
        getStateId();
        refetch();
    }, [getStateId, refetch]);

    useEffect(() => {
        if (channel) {
            channel.listen('.authorize', (payload) => {
                const { isAuthorized, connectorId } = payload;

                if (isAuthorized && connectorId) {
                    getConnectorsAccount(connectorId);
                    dispatch(setConnectorId(connectorId));
                }
            });
        }
    }, [channel, getConnectorsAccount, dispatch]);

    const renderBanks = () => {
        if (isLoading) {
            return <div>Загружаю...</div>;
        }

        if (error) {
            return (
                <>
                    <Text size='l' lineHeight='l' view='alert'>
                        Ошибка загрузки банков. Попробуйте позже
                    </Text>
                    <Button label='Переавторизорваться' size='xs' onClick={refreshState} />
                </>
            );
        }

        return data.map((item) => (
            <Card className={styles.card} border shadow={false} verticalSpace='m' horizontalSpace='m' key={item.id}>
                <div className={styles['card-wrapper']}>
                    <img className={styles.img} src={item.iconUrl} alt='Иконка банка' />
                    <Text
                        weight='semibold'
                        view={item.isAvailable ? 'primary' : 'ghost'}
                        truncate
                    >
                        {item.name}
                    </Text>
                </div>

                <Button
                    className={styles.card__btn}
                    view='ghost'
                    form='round'
                    size='s'
                    width='full'
                    label='Подключить'
                    onClick={() => connectBank({ driver: item.id })}
                    disabled={!item.isAvailable}
                />
            </Card>
        ));
    };

    return (
        <div className={styles.wrapper}>
            <Text weight='semibold' size='2xl'>
                Выберите банк
            </Text>
            <div className={styles.list}>{renderBanks()}</div>
        </div>
    );
};

export default Banks;
