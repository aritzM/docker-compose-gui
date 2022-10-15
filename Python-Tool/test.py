#!/usr/bin/python3

import unittest, os

from main import main


class TestDockerTool(unittest.TestCase):
    def test_docker_get_json(self):
        """
        Test que crea el docker
        """
        directory = "testResources/docker-test.json"
        result = main(["-i", directory])
        self.assertEqual(result, directory)

    # Tests a ejecutar remotamente habra que obtener los resultados mediante ssh y eliminar el report

    #def test_docker_create_tool(self):
    #    """
    #    Test que crea el docker
    #    """
    #    directory = "testResources/docker-test.json"
    #    result = main(["-i", directory, "-c"])
    #    self.assertEqual(result, directory)

    #def test_docker_refresh_tool(self):
    #    """
    #    Test que actualiza el docker
    #    """
    #    directory = "testResources/docker-test-updated.json"
    #    result = main(["-i", directory, "-u"])
    #    self.assertEqual(result, directory)
    
    #def test_docker_remove_tool(self):
    #    """
    #    Test que elimina el docker
    #    """
    #    directory = "testResources/docker-test-updated.json"
    #    result = main(["-i", directory, "-d"])
    #    self.assertEqual(result, directory)
    #    os.system("deluser testuser && rm -R /home/testuser")

if __name__ == '__main__':
    unittest.main()
