import logging


# def set_logger(name):
FORMAT = '%(asctime)-15s %(levelname)-5s %(message)s'
formatter = logging.Formatter(fmt=FORMAT)
handler = logging.StreamHandler()
handler.setFormatter(formatter)
logger = logging.getLogger('main')
logger.setLevel(logging.DEBUG)
logger.addHandler(handler)